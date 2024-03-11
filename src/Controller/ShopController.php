<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\services\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShopController extends AbstractController
{
    public function __construct(private CartService $serviceCart, private ProductRepository $repoProducts)
    {
        $this->serviceCart = $serviceCart;
        $this->repoProducts = $repoProducts;
    }

    #[Route('/shop-list', name: 'app_shop')]
    public function index(): Response
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
            'cart'=>$this->serviceCart->getDetails(),
            'products'=>$this->repoProducts->findAll()
        ]);
    }
}
