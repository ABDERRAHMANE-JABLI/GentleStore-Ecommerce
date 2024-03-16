<?php

namespace App\Controller;


use App\services\CartService;
use App\Repository\AdresseRepository;
use App\Repository\OrdersRepository;
use App\Repository\ProductRepository;
use App\services\StripeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CheckoutController extends AbstractController
{
    private $session;

    public function __construct(private CartService $serviceCart, 
    private RequestStack $requestStack, 
    private StripeService $stripe,
    private EntityManagerInterface $em,
    private ProductRepository $productRepo)
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
            'publicKey'=> $this->stripe->getPublicKey(),
            'controller_name' => 'CheckoutController',
        ]);
    }

    #[Route('/checkout/success-payment/{orderId}', name: 'app_payement_success')]
    public function payementSuccess(int $orderId, OrdersRepository $orderRepo): Response{
        
        //verifier si le panier n'est pas vide : 
        $cart = $this->serviceCart->getDetails();
        if(!count($cart['items'])){
            return $this->redirectToRoute('app_home');
        }
        $order = $orderRepo->findOneBy(['id'=>$orderId]);
        $order->setStatus('Processing');
        $order->setIsPayed(true);
        $this->em->persist($order);
        $this->em->flush();

        return $this->render('Payement/index.html.twig', [
            'cart'=>$cart,
            'controller_name' => 'CheckoutController',
        ]);
    }

}
