<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Swift_Mailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


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
        return $this->redirectToRoute( 'homepage' );
    }

    /**
     * @Route("/logout_success", name="user_logout_success")
     */
    public function logout_success(){
        $this->addFlash( 'dark', 'Vous êtes bien déconnecté' );
        return $this->redirectToRoute( 'homepage' );
    }
}
