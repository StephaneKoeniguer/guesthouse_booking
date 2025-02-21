<?php

namespace App\Controller;

use App\Repository\ReservationsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ReservationController extends AbstractController
{
    #[Route('/api/reservations', name: 'app_reservation', methods: ['GET'])]
    public final function getReservations(Request $request, ReservationsRepository $reservationsRepository, SerializerInterface $serializer): JsonResponse
    {
        // Récupération des paramètres de pagination et de la catégorie
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 20);

        $reservationList = $reservationsRepository->findReservationWithPagination($page, $limit);

        $reservations = $serializer->normalize($reservationList['reservations'], null, ['groups' => "getReservations"]);

        $response = [
            'reservations' => $reservations,
            'totalItems' => $reservationList['totalItems'],
            'totalPages' => $reservationList['totalPages'],
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }
}
