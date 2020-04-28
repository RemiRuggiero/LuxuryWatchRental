<?php

namespace App\Service;

use App\Repository\WatchModelRepository;


class watchlistService{
    private $WatchModelRepository;
  
    public function __construct( WatchModelRepository $WatchModelRepository ){
        $this->WatchModelRepository = $WatchModelRepository;
        
    }

    public function list(){
        
        return $this->WatchModelRepository->findByGender(1);
    }

    public function get( $id ){
        return $this->WatchModelRepository->find( $id );
    }


}