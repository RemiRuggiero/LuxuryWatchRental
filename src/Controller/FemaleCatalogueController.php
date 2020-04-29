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

class FemaleCatalogueController extends AbstractController
{


    private $watchlistService;
    

    public function __construct( watchlistService $watchlistService){
        $this->watchlistService = $watchlistService;
        
    }


    /**
     * @Route("/female/catalogue", name="female_catalogue")
     */

    public function femalewatchlist(Request $request)
    {
        $watches = $request->query->get('list');
       
        $femaleWatches = $this->watchlistService->listF();

        return $this->render( 'female_catalogue/femaleCatalogue.html.twig', array(
            'watches' => $femaleWatches,
            
        ));
         

    }

    
}
