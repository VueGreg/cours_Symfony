<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\Offer;
use App\Form\CandidacyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CandidacyController extends AbstractController
{
    #[Route('/candidacy/{id}', name: 'app_candidacy')]
    public function index(EntityManagerInterface $entity_manager, Request $request, string $id): Response
    {
        $offer = $entity_manager->getRepository(Offer::class)->find($id);

        $candidacy = new Candidacy();
        $form = $this->createForm(CandidacyType::class, $candidacy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $candidacy->setOffer($offer);
            $candidacy->addUser($this->getUser());
            
            $entity_manager->persist($candidacy);
            $entity_manager->flush();

            return $this->redirectToRoute('app_default_offers');

        }

        return $this->render('candidacy/index.html.twig', [
            'offer' => $offer,
            'form' => $form->createView()
        ]);
    }
}
