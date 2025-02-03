<?php

namespace App\Controller;

use App\Repository\RoomsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class RoomController extends AbstractController
{
    #[Route('/api/rooms', name: 'app_room', methods: ['GET'])]
    public function getRooms(RoomsRepository $roomsRepository): JsonResponse
    {
        return $this->json([
            'rooms' => $roomsRepository->findAll(),
        ]);
    }
}
