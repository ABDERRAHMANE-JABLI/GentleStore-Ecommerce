<?php

namespace App\Controller;

use App\services\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    public function __construct(private CartService $serviceCart)
    {
        $this->serviceCart = $serviceCart;
    }

    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $cart = $this->serviceCart->getDetails();
        return $this->render('cart/index.html.twig', [
            'controller_name' => 'CartController',
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{productId}/{count}', name: 'app_add_to_cart')]
    public function addTocart(string $productId, int $count): Response
    {
        if($this->serviceCart->addToCart($productId, $count) == 1){
            return $this->json($this->serviceCart->getDetails());
        }
        return $this->json(0);
    }

    #[Route('/cart/remove/{productId}/{count}', name: 'app_remove_from_cart')]
    public function removeFromCart(string $productId, int $count): Response
    {
        if($this->serviceCart->removeFromCart($productId, $count)){
            return $this->json($this->serviceCart->getDetails());
        }
        return $this->json(0);
    }

    #[Route('/cart/delete/{productId}', name: 'app_delete_from_cart')]
    public function deleteFromCart(string $productId): Response
    {
        if($this->serviceCart->deleteFromCart($productId)){
            return $this->json($this->serviceCart->getDetails());
        }
        return $this->json(0);
    }

}
