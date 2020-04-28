<?php

namespace App\Controller;

use Swift_Mailer;
use App\Entity\User;
use App\Form\RegisterType;
use App\Form\ResetPassType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/register", name="user_register")
     */
   
    public function register( Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em, GuardAuthenticatorHandler $guardHandler, Swift_Mailer $mailer) : Response
    {
        $user = new User();
        $form = $this->createForm( RegisterType::class, $user, array(
           
                'validation_groups' => ['Default', 'registration'],            
        ));
        
        $form->handleRequest( $request );

        if( $form->isSubmitted() && $form->isValid() ){
            //Encode password
            $plain = $user->getPlainPassword();
            $password = $encoder->encodePassword($user, $plain );
            $user->setPassword( $password );
            $user->setRoles( ['ROLE_USER'] );
            
            //Set gender
            $gender = $user->getGender();
            if ($gender){
                $gender = 1;
                $user->setGender($gender);
            }
            else{
                $gender = 0;
                $user->setGender($gender);
            }
            
            //Generate token
            $user->setActivationToken(bin2hex(random_bytes(16)));
            $em = $this->getDoctrine()->getManager();

            $em->persist( $user );
            $em->flush();


            //Send email
            $message = (new \Swift_Message('Nouveau compte'))
                // On attribue l'expéditeur
                ->setFrom('pierredechezlwr@gmail.com')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'email/activation.html.twig', ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                )
                ;
                $mailer->send($message);

            $this->addFlash( 'success', "Votre compte a bien été créé. Un email de confirmation vous a été envoyé." );
            return $this->redirectToRoute( 'user_login' );


        }

        return $this->render('user/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
    * @Route("/activation/{token}", name="activation")
    */
    public function activation($token, UserRepository $users)
    {
       // On recherche si un utilisateur avec ce token existe dans la base de données
       $user = $users->findOneBy(['activation_token' => $token]);

       // Si aucun utilisateur n'est associé à ce token
       if(!$user){
           // On renvoie une erreur 404
           throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
       }

       // Delete token
       $user->setActivationToken(null);
       $entityManager = $this->getDoctrine()->getManager();
       $entityManager->persist($user);
       $entityManager->flush();

       // Generate message
       $this->addFlash('success', 'Votre compte a été activé');

       // Redirect
       return $this->redirectToRoute('user_login');
    }

    /**
     * @Route("/login", name="user_login")
     */
    public function login( AuthenticationUtils $authUtils ){
        return $this->render( 'user/login.html.twig', array(
            'lastUsername' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ));
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout(){}

    /**
     * @Route("/login_success", name="user_login_success")
     */
    public function login_success(){
        $this->addFlash( 'dark', 'Vous êtes bien connecté' );
        return $this->redirectToRoute( 'account' );
    }

    /**
     * @Route("/logout_success", name="user_logout_success")
     */
    public function logout_success(){
        $this->addFlash( 'dark', 'Vous êtes bien déconnecté' );
        return $this->redirectToRoute( 'homepage' );
    }
    /**
     * @Route("/forgot_pass", name="app_forgotten_password")
     */
    public function oubliPass(Request $request, UserRepository $users, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator
    ): Response
    {
        // On initialise le formulaire
        $form = $this->createForm(ResetPassType::class);
    
        // On traite le formulaire
        $form->handleRequest($request);
    
        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données
            $donnees = $form->getData();
        
            // On cherche un utilisateur ayant cet e-mail
            $user = $users->findOneByEmail($donnees['email']);
        
            // Si l'utilisateur n'existe pas
            if ($user === null) {
                // Alerte : l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail n\'est pas connue');
                
                // On retourne sur la page de connexion
                return $this->redirectToRoute('app_forgotten_password');
            }
        
            // On génère un token
            $token = $tokenGenerator->generateToken();
        
            // On essaie d'écrire le token en base de données
            try{
                $user->setResetToken($token);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('user_login');
            }
        
            // On génère l'URL de réinitialisation de mot de passe
            $url = $this->generateUrl('app_reset_password', array('token' => $token), UrlGeneratorInterface::ABSOLUTE_URL);
        
            // On  envoie l'e-mail
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('pierredechezlwr@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    "Bonjour,<br><br>Une demande de réinitialisation du mot de passe a été effectuée pour le site LuxuryWatchRental.fr. Veuillez cliquer sur le lien suivant : <a href= ". $url .">Réinitialiser mon mot de passe</a>",
                    'text/html'
                )
            ;
                
            $mailer->send($message);
                
            // On crée le message flash de confirmation
            $this->addFlash('success', 'E-mail de réinitialisation du mot de passe envoyé !');
                
            // On redirige vers la page de login
            return $this->redirectToRoute('user_login');
        }
    
        // On envoie le formulaire à la vue
        return $this->render('user/forgotten_password.html.twig',['emailForm' => $form->createView()]);

    }


    /**
    * @Route("/reset_pass/{token}", name="app_reset_password")
    */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $encoder)
    {
        
       // On cherche un utilisateur avec le token donné
       $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['reset_token' => $token]);
       $form = $this->createForm( ResetPasswordType::class, $user );
       $form->handleRequest( $request );

       // Si l'utilisateur n'existe pas
       if ($user === null) {
           // On affiche une erreur
           $this->addFlash('danger', 'Token Inconnu');
           return $this->redirectToRoute('user_login');
       }

       // Si le formulaire est envoyé en méthode post
       if ($request->isMethod('POST')) {
           // On supprime le token
           $user->setResetToken(null);

           // On chiffre le mot de passe
            $plain = $user->getPlainPassword();
            $password = $encoder->encodePassword($user, $plain );
            $user->setPassword( $password );

           // On stocke
           $entityManager = $this->getDoctrine()->getManager();
           $entityManager->persist($user);
           $entityManager->flush();

           // On crée le message flash
           $this->addFlash('success', 'Mot de passe mis à jour');

           // On redirige vers la page de connexion
           return $this->redirectToRoute('user_login');
       }else {
           // Si on n'a pas reçu les données, on affiche le formulaire
           return $this->render('user/reset_password.html.twig', [
            'token' => $token, 
            'form' => $form->createView(),
           ]);
       }

    }
     /**
     * @Route("/account", name="account")
     */
    public function account()
    {
        $currentUser = $this->getUser();
        $locations = $currentUser->getLocations();
        
        /* foreach( $locations as $location){
            $watchEntity = $location['watchEntity'];
        } */
        //$watchModel = $watchEntity->getWatchModel();
        
        return $this->render('user/account.html.twig' , array(
            'user' => $currentUser,
            'locations' => $locations,
            //'watch' => $watchModel
        ));
    }

    
}
