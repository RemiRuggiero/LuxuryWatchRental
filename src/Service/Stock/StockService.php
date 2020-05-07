<?php

namespace App\Service\Stock;

use App\Repository\LocationRepository;
use DateTime;
use App\Repository\WatchModelRepository;

class StockService
{
    private $watchModelRepository;

    public function __construct(WatchModelRepository $watchModelRepository, LocationRepository $locationRepository)
    {
        $this->watchModelRepository = $watchModelRepository;
        $this->locationRepository = $locationRepository; 
    }
    
    public function checkStock(DateTime $dateTime, $id){
        $watchModel = $this->watchModelRepository->find($id);
        $watchEntities = $watchModel->getWatchEntities();
        $initialStock = count($watchEntities);

        $watchEntitiesId = [];
        foreach($watchEntities as $watchEntity)
        { 
            array_push($watchEntitiesId, $watchEntity->getId());
        }

        $locations = [];
        foreach($watchEntitiesId as $entityId)
        {          
            
            array_push( $locations, $this->locationRepository->findByWatchEntitiesId($entityId));
        
        }
        
        $noDispo = [];
        foreach($locations as $location)
        {
            foreach($location as $l){
            $start = $l->getStartsAt();
            $end = $l->getEndsAt();
            // $start = new DateTime($start);
            // $end = new DateTime($end);
                //dd($start, $end);
            $result = range($start->getTimesTamp(), $end->getTimesTamp(), 24*60*60);
            $days = array_map(function($dayTimestamp){ 
                return new \DateTime(date('Y-m-d', $dayTimestamp));
            }, $result );
        }

        if(empty($days)){
            break;
        }
        
        // dd($days, $dateTime); 
            foreach($days as $day)
            {               
                if($day == $dateTime)
                {
                    array_push($noDispo, $day);
                }
            }
        
        }
        
        $nbOfRent = count($noDispo);
       
        if($nbOfRent == $initialStock)
        {
            return $dateTime;
        } 
         
                
        //Recuperer les locations grace a l'id des watch Entities
        //Regarder si le DateTime est compris entre le start et end de chaque locations

        //Si il est compris dedans comparer le stock initial et le nombre de montre loué ce jour ci
        //Si le stock initial est egal au nb de montre loué alors desactivé la date sur le calendrier
    }
}