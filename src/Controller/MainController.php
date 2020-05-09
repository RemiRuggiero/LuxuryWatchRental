<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/qui/sommes/nous", name="qui_sommes_nous")
     */
    public function whoAreWe()
    {
        return $this->render('main/whoAreWe.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }


}
