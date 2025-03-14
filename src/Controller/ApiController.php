<?php

namespace App\Controller;

use App\Entity\Candidacy;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

#[Route('/api', name: 'list')]

#[OA\Response(
    response: 200,
    description: 'Returns the api',
    content: new OA\JsonContent(
        type: 'array',
        items: new OA\Items(ref: new Model(type: Offer::class, groups: ['full']))
    )
)]

final class ApiController extends AbstractController
{

// Offers -----------------------------------------------------------------------------

    #[Route('/offers', name: 'list_offers', methods:['GET'])]
    public function getOffers(EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {
        $offers = $entity_manager->getRepository(Offer::class)->findAll();

        $data = $serializer->serialize($offers, 'json', ['groups' => 'offer:read']);

        return new JsonResponse($data, 200, [], true);

    }

    #[Route('/offer/{id}', name: 'show_offer', methods:['GET'])]
    public function getOffer(Offer $offer, SerializerInterface $serializer): JsonResponse
    {

        $data = $serializer->serialize($offer, 'json', ['groups' => 'offer:read']);

        return new JsonResponse($data, 200, [], true);

    }

    #[Route('/offer/{id}', name: 'update_offer', methods:['PUT'])]
    public function updateOffer(Offer $offer ,Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Offer::class, 'json', ['object_to_populate' => $offer]);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Offer updated !'], 200);

    }

    #[Route('/offer/{id}', name: 'patch_offer', methods:['PATCH'])]
    public function patchOffer(Offer $offer ,Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Offer::class, 'json', ['object_to_populate' => $offer]);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Offer updated !'], 200);

    }

    #[Route('/offer/{id}', name: 'delete_offer', methods:['DELETE'])]
    public function deleteOffer(Offer $offer, EntityManagerInterface $entity_manager): JsonResponse
    {

        $entity_manager->remove($offer);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Offer deleted !'], 204);

    }

// Candidacies -------------------------------------------------------------

    #[Route('/candidacies', name: 'list_candidacies', methods:['GET'])]
    public function getCandidacies(EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {
        $candidacies = $entity_manager->getRepository(Candidacy::class)->findAll();

        $data = $serializer->serialize($candidacies, 'json', ['groups' => 'candidacy:read']);

        return new JsonResponse($data, 200, [], true);

    }

    #[Route('/candidacy/{id}', name: 'show_candidacy', methods:['GET'])]
    public function getCandidacy(Candidacy $candidacy, SerializerInterface $serializer): JsonResponse
    {

        $data = $serializer->serialize($candidacy, 'json', ['groups' => 'candidacy:read']);

        return new JsonResponse($data, 200, [], true);

    }

    #[Route('/candidacy/{id}', name: 'update_candidacy', methods:['PUT'])]
    public function updateCandidacy(Candidacy $candidacy ,Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Candidacy::class, 'json', ['object_to_populate' => $candidacy]);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Candidacy updated !'], 200);

    }

    #[Route('/candidacy/{id}', name: 'patch_candidacy', methods:['PATCH'])]
    public function patchCandidacy(Candidacy $candidacy ,Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Candidacy::class, 'json', ['object_to_populate' => $candidacy]);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Candidacy updated !'], 200);

    }

    #[Route('/candidacy/{id}', name: 'delete_candidacy', methods:['DELETE'])]
    public function deleteCandidacy(Candidacy $candidacy, EntityManagerInterface $entity_manager): JsonResponse
    {

        $entity_manager->remove($candidacy);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Candidacy deleted !'], 204);

    }
}
