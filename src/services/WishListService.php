<?php

namespace App\services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class WishListService{

    private $session;
    //private $repoProduct;
    public function __construct(
            private RequestStack $requestStack, 
            private ProductRepository $repoPrd,
    ){
        $this->session = $requestStack->getSession();
        $this->repoPrd = $repoPrd;
    }

    public function getWishList(){
        return $this->session->get("WishList", []);
    }

    public function setWishList($WishList){
        $this->session->set("WishList",$WishList);
    }

    public function addToWishList($productId){
        $WishList = $this->getWishList();
        $response = 0;
        if(empty($WishList[$productId])){
            $WishList[$productId] = 1;
            $this->setWishList($WishList);
            $response = 1;
        }
        return $response;
    }

    public function removeFromWishList($productId){
        $WishList = $this->getWishList();
        $response = 0;
        if(isset($WishList[$productId])){
            unset($WishList[$productId]);
            $this->setWishList($WishList);
            $response = 1;
        }
        return $response;
    }

    public function clearWishList(){
        $this->setWishList([]);
    }

    public function getDetails(){
        $WishList = $this->getWishList();
        $result = [];

        foreach($WishList as $productId => $qte){
            $prd = $this->repoPrd->find($productId);
            if($prd){
                $result[]= [$prd->getId(),$prd->getImagesUrl()[0], $prd->getName(), $prd->getSoldePrice()/100, $prd->getStock()];
            }else{
                unset($WishList[$productId]);
                $this->setWishList($WishList);
            }
        }
        return $result;
    }

}


?>