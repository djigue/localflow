<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\JwtService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /* Inscription d’un nouvel utilisateur */
    
     /* Route : /api/register (POST)*/
    #[Route('/api/register', name: 'user_register', methods: ['POST'])]
    public function register(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        // Vérification des champs requis
        if (!isset($data['prenom'], $data['nom'], $data['email'], $data['motDePasse'], $data['confirmPassword'])) {
            return new JsonResponse(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        // Vérification des mots de passe
        if ($data['motDePasse'] !== $data['confirmPassword']) {
            return new JsonResponse(['error' => 'Passwords do not match'], Response::HTTP_BAD_REQUEST);
        }

        // Création de l'utilisateur
        $user = new User();
        $user->setPrenom($data['prenom']);
        $user->setNom($data['nom']);
        $user->setEmail($data['email']);
        $user->setTelephone($data['telephone'] ?? null);

        // Hashage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['motDePasse']);
        $user->setPassword($hashedPassword);

        // Sauvegarde en base
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès !'], Response::HTTP_CREATED);
    }

    /* Connexion utilisateur avec vérification + JWT */

     /* Route : /api/login (POST) */
    #[Route('/api/login', name: 'user_login', methods: ['POST'])]
    public function login(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        JwtService $jwtService
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        // Recherche de l'utilisateur
        $user = $userRepository->findOneBy(['email' => $data['email'] ?? null]);

        // Vérification du mot de passe
        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'] ?? '')) {
            return new JsonResponse(['error' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        // Génération du token JWT
        $token = $jwtService->generateToken([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
        ]);

        return new JsonResponse(['token' => $token]);
    }
}
