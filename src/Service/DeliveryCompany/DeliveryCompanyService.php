<?php

namespace App\Service\DeliveryCompany;

use App\Repository\WatchModelRepository;
use App\Repository\DeliveryCompanyRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class DeliveryCompanyService
{

    protected $session;
    protected $deliveryCompanyRepository;

    public function __construct(SessionInterface $session, DeliveryCompanyRepository $deliveryCompanyRepository)
    {
        $this->session = $session;
        $this->deliveryCompanyRepository = $deliveryCompanyRepository;
    }
    

    public function getDeliveryCompany()
    {
        
        return $this->deliveryCompanyRepository->findAll();
    }
}