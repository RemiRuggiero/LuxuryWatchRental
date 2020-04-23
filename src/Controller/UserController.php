<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends AbstractController
{
    /**
     * @Route("/register", name="user_register")
     */
   
    public function register( Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em, GuardAuthenticatorHandler $guardHandler) : Response
    {
        $user = new User();
        $form = $this->createForm( RegisterType::class, $user );
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

            $this->addFlash( 'success', "Votre compte à bien été créé" );
            return $this->redirectToRoute( 'user_login' );

            //Send email

        }

        return $this->render('user/register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
