<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * Display détails of category
     * @param int $id
     * @param CategoryRepository $categoryRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/categories/{id}', name: 'app_detail_category', methods: ['GET'])]
    public function getDetailCategory(int $id, CategoryRepository $categoryRepository, SerializerInterface $serializer): JsonResponse
    {
        $category = $categoryRepository->find($id);
        if (!$category) {
            return new JsonResponse(['error' => 'Category not found'], Response::HTTP_NOT_FOUND);
        }

        $jsonCategory = $serializer->serialize($category, 'json', ['groups' => 'getCategory']);
        return new JsonResponse($jsonCategory, Response::HTTP_OK,['accept' => 'json'], true);
    }

    /**
     * Create a new category
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param UrlGeneratorInterface $urlGenerator
     * @param ValidatorInterface $validator
     * @return JsonResponse
     */
    #[Route('/api/categories', name: 'app_create_category', methods: ['POST'])]
    public function createRoom(Request $request, SerializerInterface $serializer,
                               EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator,
                               ValidatorInterface $validator): JsonResponse
    {
        $category = $serializer->deserialize($request->getContent(), Category::class, 'json');

        $errors = $validator->validate($category);

        if($errors->count() >  0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($category);
        $em->flush();

        $jsonCategory = $serializer->serialize($category, 'json', ['groups' => 'getCategory']);
        $location = $urlGenerator->generate('app_detail_category', ['id' => $category->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonCategory, Response::HTTP_CREATED, ['location' => $location], true);
    }

}
