<?php

namespace App\Controller;


use App\Form\AdressType;
use App\Form\PaymentType;
use App\Form\PayType;
use App\Service\Cart\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MediaService;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PaymentController extends AbstractController
{
    
    private $cartService;

    public function __construct( CartService $cartService)
    {
      
        $this->cartService = $cartService;
    }
    
    /**
     * @Route("/payment", name="payment")
     */
    public function payment( Request $request ,SessionInterface $session)
    {

        $amount = ($this->cartService->getTotal())*100;
        
        
        // Set your secret key. Remember to switch to your live secret key in production!
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_sQ77EBACzu4uZTxdERdVb05B008Cd1Q1X0');

        $intent = \Stripe\PaymentIntent::create([
        'amount' => $amount,
        'currency' => 'eur',
        // Verify your integration in this guide by including this parameter
        'metadata' => ['integration_check' => 'accept_a_payment'],
        ]);
        
        $form = $this->createForm(PaymentType::class);
        $form->handleRequest($request);
        

        if( $form->isSubmitted() && $form->isValid() ){

            
            return $this->redirectToRoute('homepage');
        }
      
        return $this->render('payment/index.html.twig', [
            'intent' => $intent,
            'items' => $this->cartService->getFullCart(),
            'form' => $form->createView()
        ]);
        
    }
    }

