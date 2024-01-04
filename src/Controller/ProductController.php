<?php

namespace App\Controller;

use App\services\CartService;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    public function __construct(private CartService $serviceCart)
    {
        $this->serviceCart = $serviceCart;//'cart'=>$this->serviceCart->getDetails(),
    }
    
    #[Route('/products/{slug}', name: 'app_product')]
    public function index(string $slug, ProductRepository $repoPrd): Response
    {
        $product = $repoPrd->findOneBy(['slug'=>$slug]);
        if(!$product){
            throw $this->createnotfoundexception();
        }
        return $this->render('product/index.html.twig', [
            'product'=>$product,
            'cart'=>$this->serviceCart->getDetails(),
            'controller_name' => 'ProductController',
        ]);
    }

    //get all products of the category : 
    #[Route('/products/category/{slug}', name: 'app_category_product')]
    public function displayProducts(string $slug, CategoryRepository $repoCat): Response
    {
       $category = $repoCat->findOneBy(['slug'=>$slug]);
        if(!$category){
            throw $this->createnotfoundexception();
        }
        //dd($category);
        return $this->render('product/productCategory.html.twig', [
            'category'=>$category,
            'cart'=>$this->serviceCart->getDetails(),
            'controller_name' => 'ProductController',
        ]);
    }
}
