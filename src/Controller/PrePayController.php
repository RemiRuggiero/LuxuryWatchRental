<?php

namespace App\Controller;

use App\Entity\Delivery;
use App\Entity\DeliveryCompany;
use App\Form\AdressType;
use App\Service\DeliveryCompany\DeliveryCompanyService;
use App\Service\MediaService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PrePayController extends AbstractController
{
    private $mediaService;
    private $deliveryCompanyService;
    
    public function __construct(MediaService $mediaService, DeliveryCompanyService $deliveryCompanyService)
    {
        $this->mediaService = $mediaService;
        $this->deliveryCompanyService = $deliveryCompanyService;
    }
    /**
     * @Route("/pre/pay", name="pre_pay")
     */
    public function index(Request $request, EntityManagerInterface $em, SessionInterface $session)
    {
        
        $deliveryCompanyId = $request->query->get('delivery');
        $deliveryCompanyId = intval($deliveryCompanyId);
        $session->set('delivery', $deliveryCompanyId);
        //dd($deliveryCompanyId);
        
        //$this->deliveryCompanyService->getOneDeliveryCompany($deliveryCompanyId);
        
        $user = $this->getUser();
        $form = $this->createForm( AdressType::class, $user, array(
           
            'validation_groups' => ['Default', 'payment'],            
        ));

        $form->handleRequest( $request );

        if( $form->isSubmitted() && $form->isValid() ){

            $file = $user->getCardFile();
            $filename = $this->mediaService->upload( $file );
            $user->setIdentityCard( $filename );

            $em->flush();
            
            return $this->redirectToRoute('payment' , array('delivery' => $deliveryCompanyId));
        }
        return $this->render('pre_pay/index.html.twig', [
            'form' => $form->createView(),
            'delivery' => $deliveryCompanyId
            
        ]);

        
    }
}
