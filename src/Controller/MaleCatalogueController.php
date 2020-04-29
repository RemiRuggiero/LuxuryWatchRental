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
       
        $maleWatches = $this->watchlistService->listM();

        return $this->render( 'male_catalogue/maleCatalogue.html.twig', array(
            'watches' => $maleWatches,
            
        ));
         

    }

        /**
     * @Route("/watch/{id}", name="watch_show", requirements={"id"="\d+"})
     */
    public function show( $id )
    {
        return $this->render( 'one_watch/show.html.twig', array(
            'watch' => $this->watchlistService->get( $id ),
        ));
    }
    
}
