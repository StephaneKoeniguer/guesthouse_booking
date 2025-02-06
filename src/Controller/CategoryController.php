<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class CategoryController extends AbstractController
{

    /**
     * Display list of categories
     * @param CategoryRepository $categoryRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/categories', name: 'app_category', methods: ['GET'])]
    public function getCategoryList(CategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {
        $categoryList = $categoryRepository->findAll();
        $jsonCategoryList = $serializer->serialize($categoryList, 'json', ['groups' => 'getCategory']);

        return new JsonResponse($jsonCategoryList, Response::HTTP_OK,[], true);
    }

}
