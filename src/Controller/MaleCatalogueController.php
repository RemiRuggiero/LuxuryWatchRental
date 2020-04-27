<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\WatchModel;
use App\Service\watchlistService;
use App\Repository\WatchModelRepository;

class MaleCatalogueController extends AbstractController
{


    private $watchlistService;
    

    public function __construct( watchlistService $watchlistService){
        $this->watchlistService = $watchlistService;
        
    }


    /**
     * @Route("/male/catalogue", name="male_catalogue")
     */

    public function malewatchlist(Request $request)
    {
        $watches = $request->query->get('list');
       
        $maleWatches = $this->watchlistService->list();

        return $this->render( 'male_catalogue/maleCatalogue.html.twig', array(
            'watches' => $maleWatches,
            
        ));
         

    }

    
}
