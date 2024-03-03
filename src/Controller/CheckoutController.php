<?php

namespace App\Controller;

use App\services\CartService;
use App\Repository\AdresseRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    private $session;

    public function __construct(private CartService $serviceCart, private RequestStack $requestStack)
    {
        $this->serviceCart = $serviceCart;//  
        $this->session = $requestStack->getSession();          
    }

    #[Route('/checkout', name: 'app_checkout')]
    public function index(AdresseRepository $adresseRepository): Response
    {
        //verifier si l'user est autentifié : 
        $user = $this->getUser();
        if(!$user){
            $this->session->set('next', 'app_checkout');
            return $this->redirectToRoute('app_login');
        }
        //verifier si le panier n'est pas vide : 
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
