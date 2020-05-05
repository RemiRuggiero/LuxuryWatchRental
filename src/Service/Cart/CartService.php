<?php

namespace App\Service\Cart;

use App\Repository\DeliveryCompanyRepository;
use App\Repository\WatchModelRepository;

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
       
        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        }        
        
        $this->session->set('panier', $panier);
    }

    public function remove(int $id)
    {
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id]))
        {
            unset($panier[$id]);
        }

        $this->session->set('panier', $panier);
    }

    public function getFullCart() : array 
    {
        $panier = $this->session->get('panier', []);
        // $date = $this->session->get('date');
        $panierWithData = [];

        foreach($panier as $id => $quantity)
        {
            $panierWithData[] = [
                'product' => $this->watchModelRepository->find($id),
                'quantity' => $quantity,
                // 'date' => $date
            ];
        }

        return $panierWithData;
    }

    public function getTotal() : float
    {
        $total = 0;

        foreach($this->getFullCart() as $item)
        {
            $total += $item['product']->getPrice() * $item['quantity'];
        }

        return $total;
    }


}