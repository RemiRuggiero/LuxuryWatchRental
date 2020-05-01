<?php

namespace App\Controller;

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
        $dateRange = $request->request->get('daterange');

        return $dateRange;

        return $this->render('one_watch/show.html.twig', [
            'controller_name' => 'OneWatchController',
        ]);
    }
}
