<?php

namespace App\Controller;

use App\services\CartService;
use App\services\WishListService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WishListController extends AbstractController
{
    public function __construct(private CartService $serviceCart, private WishListService $serviceWishList)
    {
        $this->serviceCart = $serviceCart;
        $this->serviceWishList = $serviceWishList;
    }

    #[Route('/wishlist', name: 'app_wishlist')]
    public function index(): Response
    {
        return $this->render('wish_list/index.html.twig', [
            'cart'=>$this->serviceCart->getDetails(),
            'wishlist'=>$this->serviceWishList->getDetails(),
            'controller_name' => 'WishListController',
        ]);
    }

    #[Route('/wishlist/getData', name: 'app_get_wishlist')]
    public function getData(): Response
    {
        return $this->json($this->serviceWishList->getDetails());
    }

    #[Route('/wishlist/add/{productId}', name: 'app_add_wishlist')]
    public function addToWishList(int $productId): Response
    {
        return $this->json($this->serviceWishList->addToWishList($productId));
    }

    #[Route('/wishlist/remove/{productId}', name: 'app_remove_wishlist')]
    public function removeFromWishList(int $productId): Response
    {
        return $this->json($this->serviceWishList->removeFromWishList($productId));
    }

}
