<?php

namespace App\Controller;

use App\Repository\ReviewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class ReviewController extends AbstractController
{
    /**
     * Display list of reviews
     * @param ReviewsRepository $reviewsRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/reviews', name: 'app_review', methods: ['GET'])]
    public function getReviewList(ReviewsRepository $reviewsRepository, SerializerInterface $serializer): JsonResponse
    {
        $reviewList = $reviewsRepository->findAll();
        $jsonReviewList = $serializer->serialize($reviewList, 'json', ['groups' => 'getReview']);

        return new JsonResponse($jsonReviewList, Response::HTTP_OK,[], true);
    }

    /**
     * Display detail of a review
     * @param int $id
     * @param ReviewsRepository $reviewsRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/reviews/{id}', name: 'app_detail_review', methods: ['GET'])]
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
