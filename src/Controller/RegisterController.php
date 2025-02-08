<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class RegisterController extends AbstractController
{
    /**
     * Create a new User
     * @param Request $request
     * @param UserPasswordHasherInterface $passwordHasher
     * @param ValidatorInterface $validator
     * @param SerializerInterface $serializer
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher,
                             ValidatorInterface $validator, SerializerInterface $serializer,
                             UserRepository $userRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['username']) || !isset($data['password'])) {
            return new JsonResponse("Email et mot de passe requis", Response::HTTP_BAD_REQUEST, [], true);
        }

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $userRepository->findOneBy(['email' => $data['username']]);
        if ($existingUser) {
            return new JsonResponse("Un utilisateur existe déja", Response::HTTP_BAD_REQUEST,[], true);
        }

        // Créer un nouvel utilisateur
        $user = new User();
        $user->setEmail($data['username']);
        $user->setPassword($passwordHasher->hashPassword($user,$data['password']));

        // Vérifier les contraintes sur l'entité
        $errors = $validator->validate($user);
        if (count($errors) > 0) {
            return new JsonResponse($serializer->serialize($errors, 'json'), Response::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($user);
        $em->flush();

        return new JsonResponse("Utilisateur crée", Response::HTTP_CREATED, [], true);

    }
}
