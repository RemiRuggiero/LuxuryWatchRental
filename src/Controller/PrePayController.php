<?php

namespace App\Controller;

use App\Form\AdressType;
use App\Service\MediaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PrePayController extends AbstractController
{
    private $mediaService;
    
    public function __construct(MediaService $mediaService)
    {
        $this->mediaService = $mediaService;
       
    }
    /**
     * @Route("/pre/pay", name="pre_pay")
     */
    public function index(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm( AdressType::class, $user, array(
           
            'validation_groups' => ['Default'],            
        ));

        $form->handleRequest( $request );

        if( $form->isSubmitted() && $form->isValid() ){

            $file = $user->getCardFile();
            $filename = $this->mediaService->upload( $file );
            $user->setIdentityCard( $filename );

            $em->flush();
            
            return $this->redirectToRoute('payment');
        }
        return $this->render('pre_pay/index.html.twig', [
            'form' => $form->createView(),
            
        ]);

        
    }
}
