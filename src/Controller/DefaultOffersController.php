<?php

namespace App\Controller;

use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultOffersController extends AbstractController
{
    #[Route('/default/offers', name: 'app_default_offers')]
    public function index(EntityManagerInterface $entity_manager): Response
    {
        $offers = $entity_manager->getRepository(Offer::class)->findAll();

        //dd($user);
        return $this->render('default_offers/index.html.twig', [

            'offers' => $offers,
            'user' => $this->getUser()

        ]);
    }
}
