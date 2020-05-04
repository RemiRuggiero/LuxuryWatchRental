<?php

namespace App\Controller;

use App\Entity\WatchModel;
use App\Service\watchlistService;
use App\Repository\WatchModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AllWatchesController extends AbstractController
{

    private $watchlistService;
    

    public function __construct( watchlistService $watchlistService){
        $this->watchlistService = $watchlistService;
        
    }


    /**
     * @Route("/all/watches", name="all_watches")
     */

    public function Allwatchlist(Request $request)
    {
        $watches = $request->query->get('list');
       
        $allWatches = $this->watchlistService->listA();
        $title = "Nos montres";

        return $this->render( 'catalogue/catalogue.html.twig', array(
            'watches' => $allWatches,
            'title' => $title
        ));
         
    }
}
