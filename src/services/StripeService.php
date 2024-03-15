<?php

namespace App\services;

use App\Repository\PayementRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class StripeService{

    private $session;
    public function __construct(private RequestStack $requestStack, private PayementRepository $payementRepo)
    {
        $this->session = $requestStack->getSession();
    }

    public function getPublicKey(){
        $config = $this->payementRepo->findOneByName("Stripe");
        if($_ENV['APP_ENV'] === 'dev'){
            //mode developpement : 
            return $config->getTestPublicApiKey();
        }else{
            return $config->getProdPublicApiKey();
        }
    }

    public function getPrivateKey(){
        $config = $this->payementRepo->findOneByName("Stripe");
        if($_ENV['APP_ENV'] === 'dev'){
            //mode developpement : 
            return $config->getTestPrivateApiKey();
        }else{
            return $config->getProdPrivateApiKey();
        }
    }
}

?>