<?php

namespace App\Controller;

use App\services\CartService;
use App\services\CompareService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompareController extends AbstractController
{
    public function __construct(private CartService $serviceCart, private CompareService $serviceCompare)
    {
        $this->serviceCart = $serviceCart;
        $this->serviceCompare = $serviceCompare;
    }

    #[Route('/compare', name: 'app_compare')]
    public function index(): Response
    {
        return $this->render('compare/index.html.twig', [
            'cart'=>$this->serviceCart->getDetails(),
            'controller_name' => 'CompareController',
        ]);
    }

    #[Route('/compare/getData', name: 'app_get_compare')]
    public function getCompare():Response
    {   
        $compare = $this->serviceCompare->getDetails();

        return $this->json($compare, 200, [], ['groups' => 'product']);
    }

    #[Route('/compare/add/{productId}', name: 'app_add_compare')]
    public function addToCompare($productId): Response
    {
        $response = $this->serviceCompare->addToCompare($productId);
        //dd($this->serviceCompare->getDetails()); 
        return $this->json($response);
    }

    #[Route('/compare/remove/{productId}', name: 'app_remove_compare')]
    public function removeFromCompare($productId): Response
    {
        $response = $this->serviceCompare->removeFromCompare($productId);
        return $this->json($response);
    }
}
