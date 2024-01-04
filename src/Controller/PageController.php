<?php

namespace App\Controller;

use App\services\CartService;
use App\Repository\PagesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    public function __construct(private CartService $serviceCart)
    {
        $this->serviceCart = $serviceCart;
    }

    #[Route('/pages/{slug}', name: 'app_page')]
    public function index(string $slug, PagesRepository $pages): Response
    {
        $page = $pages->findOneBy(['slug'=>$slug]);
        if (!$page) {
            throw $this->createnotfoundexception();
        }
        return $this->render('page/index.html.twig', [
            'page'=>$page,
            'cart'=>$this->serviceCart->getDetails(),
            'controller_name' => 'PageController',
        ]);
    }
}
