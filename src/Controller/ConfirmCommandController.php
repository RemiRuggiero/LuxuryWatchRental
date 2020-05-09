<?php

namespace App\Controller;

use App\Repository\DeliveryCompanyRepository;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ConfirmCommandController extends AbstractController
{
    /**
     * @Route("/confirm/command", name="confirm_command")
     */
    public function recap(Request $request, CartService $cartService, DeliveryCompanyRepository $deliveryCompanyRepository, SessionInterface $session)
    {
        $user= $this->getUser();
        $delivery= $request->query->get('delivery');
        $deliveryId= intval($delivery);
        $deliveryCompany= $deliveryCompanyRepository->find($deliveryId);
        $cart = $cartService->getFullCart();
        $total = $cartService->getTotal();
        $session->clear('panier');

        return $this->render('confirm_command/confirm.html.twig', [
            'controller_name' => 'ConfirmCommandController',
            'items' => $cart,
            'total' => $total,
            'user' => $user,
            'delivery' => $deliveryCompany,
        ]);
    }
}
