<?php

namespace App\Controller;

use App\Repository\ReviewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ReviewController extends AbstractController
{
    /**
     * Display list of reviews
     * @param Request $request
     * @param ReviewsRepository $reviewsRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/reviews', name: 'app_review', methods: ['GET'])]
    public function getReviewList(Request $request, ReviewsRepository $reviewsRepository, SerializerInterface $serializer): JsonResponse
    {
        // Récupération des paramètres de pagination de la requête
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 3);
        $reviewList = $reviewsRepository->findAllWidthPagination($page, $limit);

        $reviews = $serializer->normalize($reviewList['reviews'], null, ['groups' => 'getReview']);

        $response = [
            'reviews' => $reviews,
            'totalItems' => $reviewList['totalItems'],
            'totalPages' => $reviewList['totalPages'],
        ];

        return new JsonResponse($response, Response::HTTP_OK);

    }

    /**
     * Display a list of reviews for a given room
     * @param Request $request
     * @param ReviewsRepository $reviewsRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/reviews/rooms', name: 'app_review_room', methods: ['GET'])]
    public function getReviewListPerRoom(Request $request, ReviewsRepository $reviewsRepository, SerializerInterface $serializer): JsonResponse
    {
        // Récupération des paramètres de pagination et de la catégorie
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 3);
        $roomId = $request->get('room');

        $reviewList = $reviewsRepository->findReviewsPerRoomWithPagination($page, $limit, $roomId);

        $reviews = $serializer->normalize($reviewList['reviews'], null, ['groups' => 'getReview']);

        $response = [
            'reviews' => $reviews,
            'totalItems' => $reviewList['totalItems'],
            'totalPages' => $reviewList['totalPages'],
        ];

        return new JsonResponse($response, Response::HTTP_OK);
    }

    /**
     * Display detail of a review
     * @param int $id
     * @param ReviewsRepository $reviewsRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/reviews/{id}', name: 'app_review_details', methods: ['GET'])]
    public function getDetailReview(int $id, ReviewsRepository $reviewsRepository, SerializerInterface $serializer): JsonResponse
    {
        $review = $reviewsRepository->find($id);
        if (!$review) {
            return new JsonResponse(['error' => 'Review not found'], Response::HTTP_NOT_FOUND);
        }

        $jsonReview = $serializer->serialize($review, 'json', ['groups' => 'getReview']);
        return new JsonResponse($jsonReview, Response::HTTP_OK,['accept' => 'json'], true);
    }

}
