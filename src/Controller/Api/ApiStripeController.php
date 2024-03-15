<?php

namespace App\Controller\Api;

use App\services\StripeService;
use Stripe\StripeClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiStripeController extends AbstractController
{
    public function calculateOrderAmount($items):int{
        return 500;
    }

    #[Route('/api/strip/paymentIntent', name: 'app_api_stripe', methods:['POST'])]
    public function index(StripeService $stripSrc, Request $req):Response
    {
        try {
            $privateKey = $stripSrc->getPrivateKey();
            $stripe = new StripeClient($privateKey);
            // retrieve JSON from POST body
            //$amount = $req->getPayload()->get('amount');
            $items = null;

            // Create a PaymentIntent with amount and currency
            $paymentIntent = $stripe->paymentIntents->create([
                'amount' => $this->calculateOrderAmount($items),
                'currency' => 'eur',
                // In the latest version of the API, specifying the `automatic_payment_methods` parameter is optional because Stripe enables its functionality by default.
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
            ]);
        
            $output = [
                'clientSecret' => $paymentIntent->client_secret,
            ];
        
            return $this->json($output);
        } catch (\Throwable $e) {
            return $this->json(['error' => $e->getMessage()]);
        }
    }

    
}
