<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\services\CartService;
use App\Repository\AdresseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

//#[Route('/account/adresse')]
class AdresseController extends AbstractController
{
    public function __construct(private CartService $serviceCart)
    {
        $this->serviceCart = $serviceCart;//            'cart'=>$this->serviceCart->getDetails(),
    }

    #[Route('/api/address/add', name: 'app_add_Address', methods: ['POST'])]
    public function addAddress(Request $rq, EntityManagerInterface $manager): Response
    {
        $user = $this->getUser();
        $data = $rq->getPayload();
        $address = new Adresse();
        $address->setName($data->get('name'))
            ->setState($data->get('state'))
            ->setCity($data->get('city'))
            ->setZipCode($data->get('zip_code'))
            ->setType($data->get('type'))
            ->setClient($user);
        $manager->persist($address);
        $manager->flush();
        $result = [$address->getId(), $address->getType(), $address->getName(), $address->getCity(), $address->getState(), $address->getZipCode()];
        return $this->json($result);
    }

    #[Route('/api/address/edit/{id}', name: 'app_edit_Address', methods: ['PUT'])]
    public function editAddress(int $id,Request $rq, EntityManagerInterface $manager, AdresseRepository $adresseRepository): Response
    {
        $address = $adresseRepository->findOneById($id); // get the address by id
        if($address){
            $user = $this->getUser();
            $data = $rq->getPayload(); // get the new data
            $address->setName($data->get('name')) // update address
            ->setState($data->get('state'))
            ->setCity($data->get('city'))
            ->setZipCode($data->get('zip_code'))
            ->setType($data->get('type'))
            ->setClient($user);
            $manager->persist($address);// push to the database
            $manager->flush();
            return $this->json([
                'success'=>true,
                'msg'=>'Address Updated successfuly'
            ]);
        }
        return $this->json([
            'success'=>false,
            'msg'=>'An error occured, Please Refresh the page and try again'
        ]);
    }///api/address/edit/

    #[Route('/api/address/delete/{id}', name: 'app_remove_Address', methods: ['DELETE'])]
    public function removeAddress(int $id, EntityManagerInterface $manager, AdresseRepository $adresseRepository): Response
    {
        $address = $adresseRepository->findOneById($id);
        if($address){
            $manager->remove($address);
            $manager->flush();
            return $this->json([
                'success'=>true,
                'msg'=>'Address Deletd successfuly'
            ]);
        }
        return $this->json([
            'success'=>false,
            'msg'=>'An error occured, Refresh the page and try again'
        ]);
    }

    /*#[Route('/account/address', name: 'app_adresse_index', methods: ['GET'])]
    public function index(AdresseRepository $adresseRepository): Response
    {
        $user = $this->getUser();
        return $this->render('adresse/index.html.twig', [
            'cart'=>$this->serviceCart->getDetails(),
            'adresses' => $adresseRepository->findByClient($user),
        ]);
    }

    #[Route('/new', name: 'app_adresse_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $adresse = new Adresse();
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($adresse);
            $entityManager->flush();

            return $this->redirectToRoute('app_adresse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adresse/new.html.twig', [
            'adresse' => $adresse,
            'form' => $form,
            'cart'=>$this->serviceCart->getDetails(),
        ]);
    }
    

    #[Route('/account/address/{id}', name: 'app_adresse_show', methods: ['GET'])]
    public function show(Adresse $adresse): Response
    {
        return $this->render('adresse/show.html.twig', [
            'adresse' => $adresse,
            'cart'=>$this->serviceCart->getDetails(),
        ]);
    }

    #[Route('/account/address/{id}/edit', name: 'app_adresse_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Adresse $adresse, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdresseType::class, $adresse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_adresse_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('adresse/edit.html.twig', [
            'adresse' => $adresse,
            'form' => $form,
            'cart'=>$this->serviceCart->getDetails(),
        ]);
    }

    #[Route('/account/address/{id}', name: 'app_adresse_delete', methods: ['POST'])]
    public function delete(Request $request, Adresse $adresse, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adresse->getId(), $request->request->get('_token'))) {
            $entityManager->remove($adresse);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_adresse_index', [], Response::HTTP_SEE_OTHER);
    }*/

}
