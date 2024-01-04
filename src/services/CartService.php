<?php

namespace App\services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService{

    private $session;
    //private $repoProduct;
    public function __construct(
            private RequestStack $requestStack, 
            private ProductRepository $repoPrd,
    ){
        $this->session = $requestStack->getSession();
        $this->repoPrd = $repoPrd;
    }

    public function getCart(){
        return $this->session->get("cart", []);
    }

    public function setCart($cart){
        $this->session->set("cart",$cart);
    }

    public function addToCart($productId, $qte = 1){
        $cart = $this->getCart();
        $response = 0;
        if(!empty($cart[$productId])){
            $cart[$productId] += $qte;
            $response = 1;
        }
        else{
            $cart[$productId] = $qte;
            $response = 1;
        }
        $this->setCart($cart);
        return $response;
    }

    public function removeFromCart($productId, $qte = 1){
        $cart = $this->getCart();
        $response = 0;
        if(!empty($cart[$productId])){
            if($cart[$productId] <= $qte){
                unset($cart[$productId]);
            }else{
                $cart[$productId] -= $qte;
            }
            $response = 1;
        }
        $this->setCart($cart);
        return $response;
    }

    public function deleteFromCart($productId){
        $cart = $this->getCart();
        $response = 0;
        if(isset($cart[$productId])){
            unset($cart[$productId]);
            $response = 1;
        }
        $this->setCart($cart);
        return $response;
    }


    public function clearCart(){
        $this->setCart([]);
    }

    public function getDetails(){
        $cart = $this->getCart();
        $total = 0;
        $result = ["items"=>[], "Total"=>0, 'length'=>0];

        foreach($cart as $productId => $qte){
            $prd = $this->repoPrd->find($productId);
            if($prd){
                $price = $prd->getSoldePrice()*$qte / 100;
                $total += $price;
                $result["items"][]=[
                    'product' =>[
                        'id'=>$prd->getId(),
                        'name'=>$prd->getName(),
                        'image'=>$prd->getImagesUrl()[0],
                        'soldePrice'=>$prd->getSoldePrice(),
                        'stock'=>$prd->getStock()
                    ],
                    'Price'=>$price,
                    'qte'=>$qte,
                ]; 
            }else{
                unset($cart[$productId]);
                $this->setCart($cart);
            }
        }
        $result["Total"] = $total;
        $result["length"] = count($cart);
        return $result;
    }

}


?>