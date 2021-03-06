<?php

namespace App\Controller;

use App\Service\Cart\CartService;

use App\Controller\OneWatchController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DeliveryCompany\DeliveryCompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartController extends AbstractController
{
    private $deliveryCompanyService;
    public function __construct( DeliveryCompanyService $deliveryCompanyService)
    {
        $this->DeliveryCompanyService = $deliveryCompanyService;
    }


    /**
     * @Route("/panier", name="cart_index")
     * 
     */
    public function index(CartService $cartService, SessionInterface $session, Request $request)
    {
         
        //$session->clear();
    
        return $this->render('cart/cart.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'companies' => $this->DeliveryCompanyService->getDeliveryCompany()
        ]);
        
    }

    
    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService, SessionInterface $session, Request $request )
    {
        $date = $request->request->get('daterange');

        $session->set('date', $date ); 
        $cartService->add($id, $date);
    

       return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/remove/{id}/{key}", name="cart_remove")
     */
    public function remove($id, $key, CartService $cartService)
    {
        $cartService->remove($id, $key);

        return $this->redirectToRoute('cart_index');
    }
    
}
