<?php

namespace App\Controller\Api;

use App\Entity\Orders;
use App\Entity\OrderDetails;
use App\Repository\AdresseRepository;
use App\Repository\ProductRepository;
use App\services\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiOrderController extends AbstractController
{
    public function __construct(private ProductRepository $productRepo, private EntityManagerInterface $em)
    {
    }

    #[Route('/api/orders', name: 'app_orders', methods:['POST'])]
    public function index( Request $req, CartService $cartService, AdresseRepository $addr):Response
    {
        try {
            $data = $req->getPayload();
            $shipping_addr = $data->get('shipping_addr');
            $billing_addr = $data->get('billing_addr');
            $cart = $cartService->getDetails();
            $order = new Orders();
            $order->setClient($this->getUser())
                  ->setTotal($cart['Total'])
                  ->setShippingAddr($addr->findOneBy(['id'=>$shipping_addr]))
                  ->setBillingAddr($addr->findOneBy(['id'=>$billing_addr]));
            $this->em->persist($order);

            foreach ($cart['items'] as $key => $item) {
                //$product = $item['product'];
                //dd($product);
                $product = $this->productRepo->findOneBy(['id' => $item['product']['id']]);
                $orderDetails = new OrderDetails();
                $orderDetails->setProduct($product)
                        ->setTheOrder($order)
                        ->setQuantity($item['qte']);
                $this->em->persist($orderDetails);
            }
            $this->em->flush();
            return $this->json(['success'=>true, 'data'=>$order->getId()]);
            // Create a PaymentIntent with amount and currency
           
        } catch (\Throwable $e) {
            return $this->json(['success'=>false, 'error' => $e->getMessage()]);
        }
    }

    
}
