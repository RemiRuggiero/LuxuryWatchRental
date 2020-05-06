<?php

namespace App\Controller;

use DateTime;
use DatePeriod;
use DateInterval;
use App\Entity\WatchModel;
use App\Service\Cart\CartService;
use App\Service\watchlistService;
use App\Service\Stock\StockService;
use App\Repository\WatchModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MaleCatalogueController extends AbstractController
{


    private $watchlistService;
    private $session;
    private $cartService;
    

    public function __construct( watchlistService $watchlistService, SessionInterface $session , CartService $cartService){
        $this->watchlistService = $watchlistService;
        $this->SessionInterface = $session;
        $this->CartService = $cartService;

        
    }


    /**
     * @Route("/male/catalogue", name="male_catalogue")
     */

    public function malewatchlist(Request $request)
    {
        $watches = $request->query->get('list');
       
        $maleWatches = $this->watchlistService->listM();
        $title ="Montres homme";

        return $this->render( 'catalogue/catalogue.html.twig', array(
            'watches' => $maleWatches,
            'title' => $title
            
        ));
         

    }

    /**
     * @Route("/watch/{id}", name="watch_show", requirements={"id"="\d+"})
     */
    public function show( $id, Request $request, StockService $stockService )
    {   
        $startDate = new DateTime('now');    
        $start = date('Y-m-d');        
        $startDateTimestamp = strtotime($start);
        $duree = 6;
        $end = date('Y-m-d', strtotime('+'.$duree.'month', $startDateTimestamp ));
        $disabledDate = [];
        foreach(new DatePeriod($startDate, new DateInterval('P1D'), $end) as $dt)           
        {
            
            $a = new DateTime($dt->format('Y-m-d'));
            if($stockService->checkStock($a, $id)) {
                array_push($disabledDate, $stockService->checkStock($a, $id) );
            }           
            
        }
       // dd($disabledDate);
 
        header("Content-type: text/javascript");
        $jsonArray = json_encode($disabledDate);
 
        return $this->render( 'one_watch/show.html.twig', array(
            'watch' => $this->watchlistService->get( $id ),
            'jsonArray' => $jsonArray
        ));

    }
    
}
