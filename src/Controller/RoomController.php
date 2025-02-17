<?php

namespace App\Controller;

use App\Entity\Rooms;
use App\Repository\RoomsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RoomController extends AbstractController
{
    /**
     * Display a list of rooms with pagination
     * @param Request $request
     * @param RoomsRepository $roomsRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/rooms', name: 'app_room', methods: ['GET'])]
    public function getRoomList(Request $request, RoomsRepository $roomsRepository, SerializerInterface $serializer): JsonResponse
    {
        // Récupération des paramètres de pagination de la requête
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 2);
        $roomList = $roomsRepository->findAllWidthPagination($page, $limit);

        $rooms = $serializer->normalize($roomList['rooms'], null, ['groups' => 'getRooms']);

        $response = [
            'rooms' => $rooms,
            'totalItems' => $roomList['totalItems'],
            'totalPages' => $roomList['totalPages'],
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * Display a list of rooms for a given category
     * @param Request $request
     * @param RoomsRepository $roomsRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/rooms/category', name: 'app_room_category', methods: ['GET'])]
    public function getRoomListPerCategory(Request $request, RoomsRepository $roomsRepository, SerializerInterface $serializer): JsonResponse
    {
        // Récupération des paramètres de pagination et de la catégorie
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 2);
        $categoryId = $request->get('category');

        $roomList = $roomsRepository->findRoomsPerCategoryWithPagination($page, $limit, $categoryId);

        $rooms = $serializer->normalize($roomList['rooms'], null, ['groups' => 'getRooms']);

        $response = [
            'rooms' => $rooms,
            'totalItems' => $roomList['totalItems'],
            'totalPages' => $roomList['totalPages'],
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }


    /**
     *  Display details of a Room
     * @param int $id
     * @param RoomsRepository $roomsRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/rooms/{id}', name: 'app_detail_room', methods: ['GET'])]
    public function getDetailRoom(int $id, RoomsRepository $roomsRepository, SerializerInterface $serializer): JsonResponse
    {
        $room = $roomsRepository->find($id);
        if (!$room) {
            return new JsonResponse(['error' => 'Room not found'], Response::HTTP_NOT_FOUND);
        }

        $jsonRoom = $serializer->serialize($room, 'json', ['groups' => 'getRooms']);
        return new JsonResponse($jsonRoom, Response::HTTP_OK,['accept' => 'json'], true);
    }

    /**
     * Create a new Room
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param UrlGeneratorInterface $urlGenerator
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    #[Route('/api/rooms', name: 'app_create_room', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function createRoom(Request $request, SerializerInterface $serializer,
                               EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator,
                               ValidatorInterface $validator): JsonResponse
    {
        $room = $serializer->deserialize($request->getContent(), Rooms::class, 'json');

        $errors = $validator->validate($room);

        if($errors->count() >  0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($room);
        $em->flush();

        $jsonRoom = $serializer->serialize($room, 'json', ['groups' => 'getRooms']);
        $location = $urlGenerator->generate('app_detail_room', ['id' => $room->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonRoom, Response::HTTP_CREATED, ['location' => $location], true);
    }

    /**
     * Update a Room
     * @param int $id
     * @param Request $request
     * @param RoomsRepository $roomsRepository
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    #[Route('/api/rooms/{id}', name: 'app_update_room', methods: ['PUT'])]
    #[IsGranted('ROLE_USER')]
    public function UpdateRoom(int $id, Request $request, RoomsRepository $roomsRepository,
                               SerializerInterface $serializer, EntityManagerInterface $em,
                               ValidatorInterface $validator): JsonResponse
    {

        // Vérifier si le corps de la requête est vide
        if (empty($request->getContent())) {
            return new JsonResponse(['message' => 'Request body cannot be empty'], Response::HTTP_BAD_REQUEST);
        }

        $updateRoom = $serializer->deserialize($request->getContent(),
            Rooms::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $roomsRepository->find($id)]);

        $errors = $validator->validate($updateRoom);

        if($errors->count() >  0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($updateRoom);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Delete a Room
     * @param int $id
     * @param RoomsRepository $roomsRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    #[Route('/api/rooms/{id}', name: 'app_delete_room', methods: ['DELETE'])]
    #[IsGranted('ROLE_USER')]
    public function deleteRoom(int $id, RoomsRepository $roomsRepository, EntityManagerInterface $em): JsonResponse
    {
        $room = $roomsRepository->find($id);
        if (!$room) {
            return new JsonResponse(['error' => 'Room not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($room);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

}
