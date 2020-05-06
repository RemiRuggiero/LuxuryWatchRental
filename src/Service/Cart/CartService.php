<?php

namespace App\Service\Cart;

use DateTime;
use App\Repository\WatchModelRepository;


use App\Repository\DeliveryCompanyRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{

    protected $session;
    protected $watchModelRepository;

    public function __construct(SessionInterface $session, WatchModelRepository $watchModelRepository)
    {
        $this->session = $session;
        $this->watchModelRepository = $watchModelRepository;
        
    }
    public function add(int $id, $date)
    {
        $panier = $this->session->get('panier', []);
        $d = explode(' - ', $date);
        $startsAt = $d[0];
        $endsAt = $d[1];

        if(!empty($panier[$id]))
        {
            array_push($panier[$id], ['startsAt' => $startsAt, 'endsAt' => $endsAt
            ]);
        } else {
            $panier[$id] = array(['startsAt' => $startsAt, 'endsAt' => $endsAt
            ]);
        }           
        
        // $a = count($panier[$id]);
        // $this->session->set('a', $a);        
        
        $this->session->set('panier', $panier);
    }

    public function remove(int $id, $key)
    {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id]))
        {
            unset($panier[$id][$key]);
        }
       /*  if(empty($panier[$id][$key])){
            unset($panier[$id]);
        } */

        $this->session->set('panier', $panier);
    }

    public function getFullCart() : array 
    {
        $panier = $this->session->get('panier', []);
        $panierWithData = [];

        foreach($panier as $id => $watch)
        {
            $watchModel = $this->watchModelRepository->find($id);
            $watchEntities = $watchModel->getWatchEntities();
            $stock = count($watchEntities);
            
            foreach($watch as $date){
                $date1 = new DateTime($date['startsAt']);
                $date2 = $date1->diff(new DateTime($date['endsAt']));               
                $key = array_search($date, $watch);                
                
                if($stock <= 0){
                    return null;
                }else{
                    $stock--;
                    $panierWithData[] = [
                        'product' => $watchModel,
                        'serialNumber' => $watchEntities,
                        'days' => $date2->days,
                        'startsAt' => $date['startsAt'],
                        'endsAt' => $date['endsAt'],
                        'key' => $key,
                        'stock' => $stock
                    ];} 
        }}

        return $panierWithData;
    }

    public function getTotal() : float
    {
        $total = 0;

        foreach($this->getFullCart() as $item)
        {
            $total += $item['product']->getPrice() * $item['days'];
        }

        return $total;
    }

    


}