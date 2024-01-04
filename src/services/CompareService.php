<?php

namespace App\services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CompareService{

    private $session;
    //private $repoProduct;
    public function __construct(
            private RequestStack $requestStack, 
            private ProductRepository $repoPrd,
    ){
        $this->session = $requestStack->getSession();
        $this->repoPrd = $repoPrd;
    }

    public function getCompare(){
        return $this->session->get("Compare", []);
    }

    public function setCompare($Compare){
        $this->session->set("Compare",$Compare);
    }

    public function addToCompare($productId){
        $Compare = $this->getCompare();
        $response = 0;
        if(empty($Compare[$productId])){
            $Compare[$productId] = 1;
            $this->setCompare($Compare);
            $response = 1;
        }
        return $response;
    }

    public function removeFromCompare($productId){
        $Compare = $this->getCompare();
        $response = 0;
        if(isset($Compare[$productId])){
            unset($Compare[$productId]);
            $this->setCompare($Compare);
            $response = 1;
        }
        return $response;
    }

    public function clearCompare(){
        $this->setCompare([]);
    }

    public function getDetails(){
        $Compare = $this->getCompare();
        $result = [];

        foreach($Compare as $productId => $qte){
            $prd = $this->repoPrd->find($productId);
            if($prd){
                $result[]= [$prd->getId(),$prd->getImagesUrl()[0], $prd->getName(), $prd->getSoldePrice()/100, $prd->getStock(),$prd->getBrand()];
            }else{
                unset($Compare[$productId]);
                $this->setCompare($Compare);
            }
        }
        return $result;
    }

}


?>