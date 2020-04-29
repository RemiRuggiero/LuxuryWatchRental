<?php

namespace App\Service;

use App\Repository\WatchModelRepository;


class watchlistService{
    private $WatchModelRepository;
  
    public function __construct( WatchModelRepository $WatchModelRepository ){
        $this->WatchModelRepository = $WatchModelRepository;
        
    }

    public function listM(){
        
        return $this->WatchModelRepository->findByGender(1);
    }

    public function listF(){
        
        return $this->WatchModelRepository->findByGender(0);
    }

    public function listA(){

        return $this->WatchModelRepository->findAll();

    }

}