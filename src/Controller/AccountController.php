<?php

namespace App\Controller;
use App\Repository\AdresseRepository;
use App\Repository\OrdersRepository;
use App\services\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    public function __construct(private CartService $serviceCart, private OrdersRepository $orderRepo)
    {
        $this->serviceCart = $serviceCart; //            'cart'=>$this->serviceCart->getDetails(),
    }

    #[Route('/account', name: 'app_account')]
    public function index(AdresseRepository $adresseRepository): Response
    {
        $user = $this->getUser();
        if(!$user){
            return $this->redirectToRoute('app_home');
        }
        $orders = $this->orderRepo->findByclient($user);
        return $this->render('account/index.html.twig', [
            'cart' => $this->serviceCart->getDetails(),
            'adresses' => $adresseRepository->findByClient($user),
            'orders'=>$orders,
            'controller_name' => 'AccountController',
        ]);
    }
    
}
