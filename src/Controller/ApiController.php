<?php

namespace App\Controller;

use ApiPlatform\OpenApi\Model\Response;
use App\Entity\Candidacy;
use App\Entity\Offer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Nelmio\ApiDocBundle\Attribute\Model;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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


    #[OA\Tag(name: 'Offers')]
    #[Route('/offers', name: 'list_offers', methods:['GET'])]
    public function getOffers(EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {
        $offers = $entity_manager->getRepository(Offer::class)->findAll();

        $data = $serializer->serialize($offers, 'json', ['groups' => 'offer:read']);

        return new JsonResponse($data, 200, [], true);

    }

    #[OA\Tag(name: 'Offers')]
    #[Route('/offers/{tag}', name: 'list_offers_tags', methods:['GET'])]
    public function getOffersByTag(EntityManagerInterface $entity_manager, string $tag): JsonResponse
    {
        if ($tag !== "") {
            $offers = $entity_manager->getRepository(Offer::class)->findByTag($tag);
        }else {
            $offers = $entity_manager->getRepository(Offer::class)->findAll();
        }

        return new JsonResponse($offers, 200, [], true);

    }   

    #[OA\Tag(name: 'Offers')]
    #[Route('/offer/{id}', name: 'show_offer', methods:['GET'])]
    public function getOffer(Offer $offer, SerializerInterface $serializer): JsonResponse
    {

        $data = $serializer->serialize($offer, 'json', ['groups' => 'offer:read']);

        return new JsonResponse($data, 200, [], true);

    }

    #[OA\Tag(name: 'Offers')]
    #[Route('/offer/{id}', name: 'update_offer', methods:['PUT'])]
    public function updateOffer(Offer $offer ,Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Offer::class, 'json', ['object_to_populate' => $offer]);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Offer updated !'], 200);

    }

    #[OA\Tag(name: 'Offers')]
    #[Route('/offer/{id}', name: 'patch_offer', methods:['PATCH'])]
    public function patchOffer(Offer $offer ,Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Offer::class, 'json', ['object_to_populate' => $offer]);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Offer updated !'], 200);

    }

    #[OA\Tag(name: 'Offers')]
    #[Route('/offers', name: 'post_offer', methods:['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(
            required: ['title', 'description', 'tag', 'city'],
            properties: [
                new OA\Property(property: 'title', type: 'string', description: 'Title of the candidacy'),
                new OA\Property(property: 'description', type: 'string', description: 'Description of the candidacy'),
                new OA\Property(property: 'tag', type: 'string', description: 'Tag of the candidacy'),
                new OA\Property(property: 'city', type: 'string', description: 'City of the candidacy'),
            ]
        )
    )]
    public function postOffer(Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $offer = $serializer->deserialize($request->getContent(), Offer::class, 'json');
        $user = $this->getUser();
        $offer->setRecruiter($user);
        $entity_manager->persist($offer);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'offer created !'], 201);

    }

    #[OA\Tag(name: 'Offers')]
    #[Route('/offer/{id}', name: 'delete_offer', methods:['DELETE'])]
    public function deleteOffer(Offer $offer, EntityManagerInterface $entity_manager): JsonResponse
    {

        $entity_manager->remove($offer);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Offer deleted !'], 204);

    }

// Candidacies -------------------------------------------------------------

    #[OA\Tag(name: 'Candidacies')]
    #[Route('/candidacies', name: 'list_candidacies', methods:['GET'])]
    public function getCandidacies(EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {
        $candidacies = $entity_manager->getRepository(Candidacy::class)->findAll();

        $data = $serializer->serialize($candidacies, 'json', ['groups' => 'candidacy:read']);

        return new JsonResponse($data, 200, [], true);

    }

    #[OA\Tag(name: 'Candidacies')]
    #[Route('/candidacy/{id}', name: 'show_candidacy', methods:['GET'])]
    public function getCandidacy(Candidacy $candidacy, SerializerInterface $serializer): JsonResponse
    {

        $data = $serializer->serialize($candidacy, 'json', ['groups' => 'candidacy:read']);

        return new JsonResponse($data, 200, [], true);

    }

    #[OA\Tag(name: 'Candidacies')]
    #[Route('/candidacy/{id}', name: 'update_candidacy', methods:['PUT'])]
    public function updateCandidacy(Candidacy $candidacy ,Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Candidacy::class, 'json', ['object_to_populate' => $candidacy]);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Candidacy updated !'], 200);

    }

    #[OA\Tag(name: 'Candidacies')]
    #[Route('/candidacy/{id}', name: 'patch_candidacy', methods:['PATCH'])]
    public function patchCandidacy(Candidacy $candidacy ,Request $request, EntityManagerInterface $entity_manager, SerializerInterface $serializer): JsonResponse
    {

        $serializer->deserialize($request->getContent(), Candidacy::class, 'json', ['object_to_populate' => $candidacy]);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Candidacy updated !'], 200);

    }

    #[OA\Tag(name: 'Candidacies')]
    #[Route('/candidacies', name: 'post_candidacies', methods:['POST'])]
    #[OA\RequestBody(
        required: true,
        content: new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                required: ['message', 'file'],
                properties: [
                    new OA\Property(property: 'message', type: 'string', description: 'Message of the candidacy'),
                    new OA\Property(property: 'file', type: 'string', format: 'binary', description: 'CV of the candidacy'),
                ]
            )
        )
    )]
    function postCandidacies(Request $request, EntityManagerInterface $entity_manager): JsonResponse
    {

        $candidacy = new Candidacy();
        $message = $request->request->get('message');
        $candidacy->setMessage($message);
        $candidacy->setOffer($entity_manager->getRepository(Offer::class)->find(1));

        $file = $request->files->get('file');

        if (!$file) {
            return new JsonResponse(['error' => 'Aucun fichier reçu'], HttpFoundationResponse::HTTP_BAD_REQUEST);
        }

        $uploadDir = $this->getParameter('kernel.project_dir') . 'var';

        $newFileName = uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($uploadDir, $newFileName);
        } catch (FileException $e) {
            return new JsonResponse(['error' => 'Erreur lors de l\'upload'], HttpFoundationResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

        $candidacy->setFile($newFileName);
        $entity_manager->persist($candidacy);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Candidacy created !'], 201);

    }
    
    #[OA\Tag(name: 'Candidacies')]
    #[Route('/candidacy/{id}', name: 'delete_candidacy', methods:['DELETE'])]
    public function deleteCandidacy(Candidacy $candidacy, EntityManagerInterface $entity_manager): JsonResponse
    {

        $entity_manager->remove($candidacy);
        $entity_manager->flush();

        return new JsonResponse(['message' => 'Candidacy deleted !'], 204);

    }
}