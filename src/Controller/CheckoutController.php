<?php

namespace App\Controller;

use App\services\CartService;
use App\Repository\AdresseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    public function __construct(private CartService $serviceCart)
    {
        $this->serviceCart = $serviceCart;//            
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function index(AdresseRepository $adresseRepository): Response
    {
        $cart = $this->serviceCart->getDetails();
        if(!count($cart['items'])){
            return $this->redirectToRoute('app_home');
        }
        $adresses = $adresseRepository->findByClient($this->getUser());
        return $this->render('checkout/index.html.twig', [
            'cart'=>$cart,
            'adresses' => $adresses,
            'controller_name' => 'CheckoutController',
        ]);
    }
}
