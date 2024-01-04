<?php

namespace App\Controller;

use App\services\CartService;
use App\Repository\ProductRepository;
use App\Repository\SlidersRepository;
use App\Repository\CategoryRepository;
use App\Repository\SettingsRepository;
use App\Repository\CollectionsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(private ProductRepository $repoProducts, private CartService $serviceCart)
    {
        $this->repoProducts = $repoProducts;
        $this->serviceCart = $serviceCart;
    }

    #[Route('/', name: 'app_home')]
    public function index(SettingsRepository $setting, 
                        SlidersRepository $s,
                        CollectionsRepository $repoCollection,
                        CategoryRepository $repoCategorie,
                        Request $rq): Response
    {
        $session = $rq->getSession();
        $data = $setting->findAll();
        $session->set('settings', $data[0]);
        $sliders = $s->findAll();
        $collections = $repoCollection->findAll();
        $categories = $repoCategorie->findAll();
        $session->set('categories',$categories);
        return $this->render('home/index.html.twig', [
            'sliders'=>$sliders,
            'collections'=>$collections,
            'controller_name' => 'HomeController',
            'cart'=>$this->serviceCart->getDetails(),
            'bestSellers'=>$this->repoProducts->findBy(['isBestSeller'=>true]),
            'newArrivals'=>$this->repoProducts->findBy(['isNewArrival'=>true]),
            'featureds'=>$this->repoProducts->findBy(['isFeatured'=>true]),
            'specialOffers'=>$this->repoProducts->findBy(['isSpecialOffer'=>true]),
        ]);
    }
}
