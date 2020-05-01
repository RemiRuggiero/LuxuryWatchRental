<?php

namespace App\Controller;

use App\Entity\WatchModel;
use App\Service\Cart\CartService;
use App\Service\watchlistService;
use App\Repository\WatchModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class MaleCatalogueController extends AbstractController
{


    private $watchlistService;
    private $session;
    

    public function __construct( watchlistService $watchlistService, SessionInterface $session){
        $this->watchlistService = $watchlistService;
        $this->SessionInterface = $session;

        
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
    public function show( $id, Request $request,  SessionInterface $session )
    {
         $dateRange = $request->request->get('daterange');
        $date = 12;
        $session->set('date', $dateRange); 
        //dd($session->get('date'));
        
        return $this->render( 'one_watch/show.html.twig', array(
            'watch' => $this->watchlistService->get( $id ),
        ));
    }
    
}
