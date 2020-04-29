<?php

namespace App\Controller;

use App\Repository\WatchModelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    
    /**
     * @Route("/male/catalogue", name="product_index")
     */
    public function index(WatchModelRepository $watchModelRepository)
    {
        return $this->render('male_catalogue/maleCatalogue.html.twig', [
            'products' => $watchModelRepository->findAll()
        ]);
    }
}
