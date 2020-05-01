<?php

namespace App\Controller;

use App\Service\Cart\CartService;

use App\Controller\OneWatchController;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\DeliveryCompany\DeliveryCompanyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
    public function index(CartService $cartService)
    {
         
        // $cartService->session->clear();

        //dd($cartService->getFullCart());
        return $this->render('cart/cart.html.twig', [
            'items' => $cartService->getFullCart(),
            'total' => $cartService->getTotal(),
            'companies' => $this->DeliveryCompanyService->getDeliveryCompany()
        ]);
        
    }

    
    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */
    public function add($id, CartService $cartService )
    {
        $cartService->add($id);

       return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */
    public function remove($id, CartService $cartService)
    {
        $cartService->remove($id);

        return $this->redirectToRoute('cart_index');
    }

     
}
