<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OneWatchController extends AbstractController
{
       /**
     * @Route("/one/watch", name="one_watch")
     */
    public function show(Request $request)
    {
        return $this->render('one_watch/show.html.twig', [
            'items' => $this->cartService->getFullCart(),
        ]);
    }
}
