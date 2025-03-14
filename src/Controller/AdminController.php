<?php

namespace App\Controller;

use App\Entity\Offer;
use App\Form\OfferType;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Void_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin')]
final class AdminController extends AbstractController
{
    #[Route('/', name: 'app_admin')]
    public function index(EntityManagerInterface $entity_manager): Response
    {

        $offers = $entity_manager->getRepository(Offer::class)->findAll();

        return $this->render('admin/index.html.twig', [
            'offers' => $offers
        ]);
    }

    #[Route('/add-offer', name: 'app_add_offer')]
    public function addOffer(EntityManagerInterface $entity_manager, Request $request): Response
    {
        $offer = new Offer();

        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $offer->setRecruiter($this->getUser());

            $entity_manager->persist($offer);
            $entity_manager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/addOffer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/edit-offer/{id}', name: 'app_edit_offer')]
    public function editOffer(EntityManagerInterface $entity_manager, Request $request, string $id): Response
    {
        $offer = $entity_manager->getRepository(Offer::class)->find($id);

        $form = $this->createForm(OfferType::class, $offer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $offer->setRecruiter($this->getUser());

            $entity_manager->persist($offer);
            $entity_manager->flush();

            return $this->redirectToRoute('app_admin');
        }

        return $this->render('admin/editOffer.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/delete-offer/{id}', name: 'app_delete_offer')]
    public function deleteOffer(EntityManagerInterface $entity_manager, string $id): Response
    {
        $offer = $entity_manager->getRepository(Offer::class)->find($id);

        $entity_manager->remove($offer);
        $entity_manager->flush();

        return $this->redirectToRoute('app_admin');
    }
}
