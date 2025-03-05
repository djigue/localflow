<?php

// namespace App\Controller;

// use App\Entity\User;
// use App\Form\UserType;
// use App\Repository\UserRepository;
// use Doctrine\ORM\EntityManagerInterface;
// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Attribute\Route;

// #[Route('/user')]
// final class UserController extends AbstractController
// {
//     #[Route(name: 'app_user_index', methods: ['GET'])]
//     public function index(UserRepository $userRepository): Response
//     {
//         return $this->render('user/index.html.twig', [
//             'users' => $userRepository->findAll(),
//         ]);
//     }

//     #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
//     public function new(Request $request, EntityManagerInterface $entityManager): Response
//     {
//         $user = new User();
//         $form = $this->createForm(UserType::class, $user);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $entityManager->persist($user);
//             $entityManager->flush();

//             return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
//         }

//         return $this->render('user/new.html.twig', [
//             'user' => $user,
//             'form' => $form,
//         ]);
//     }

//     #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
//     public function show(User $user): Response
//     {
//         return $this->render('user/show.html.twig', [
//             'user' => $user,
//         ]);
//     }

//     #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
//     public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
//     {
//         $form = $this->createForm(UserType::class, $user);
//         $form->handleRequest($request);

//         if ($form->isSubmitted() && $form->isValid()) {
//             $entityManager->flush();

//             return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
//         }

//         return $this->render('user/edit.html.twig', [
//             'user' => $user,
//             'form' => $form,
//         ]);
//     }

//     #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
//     public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
//     {
//         if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->getPayload()->getString('_token'))) {
//             $entityManager->remove($user);
//             $entityManager->flush();
//         }

//         return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
//     }
// }

// src/Controller/UserController.php
namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class UserController extends AbstractController
{
    #[Route('/api/users/inscription', name: 'api_user_signup', methods: ['POST'])]
    public function signup(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setEmail($data['email']);
        $user->setRoles($data['roles']);
        
        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], 201);
    }

    #[Route('/api/users/connexion', name: 'api_user_connexion', methods: ['POST'])]
    public function connexion(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, SessionInterface $session): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'])) {
            return new JsonResponse(['error' => 'Données incomplètes'], 400);
        }

        $user = $em->getRepository(User::class)->findOneBy(['email' => $data['email']]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return new JsonResponse(['error' => 'Identifiants incorrects'], 401);
        }

        $token = bin2hex(random_bytes(32));

        // Stockage en session
        $session->set('token', $token);
        $session->set('user_id', $user->getId());
        $session->set('user_email', $user->getEmail());

        return new JsonResponse([
            'message' => 'Connexion réussie',
            'token' => $token,
            'user_id' => $user->getId(),
            'user_email'=> $user->getEmail(),
        ], 200);
    }

    #[Route('/api/users/deconnexion', name: 'api_user_deconnexion', methods: ['POST'])]
    public function deconnexion(Request $request, SessionInterface $session): JsonResponse
    {
        
            dump($session->get('token'));  // Affiche le token
            dump($session->get('user_id'));  // Affiche l'id utilisateur
            
        
            $data = json_decode($request->getContent(), true);
    
            if (!isset($data['token'], $data['user_id'])) {
                return new JsonResponse(['message' => 'Données manquantes ou invalides', 'data' => $data], 400);
            }
    
            $token = $data['token'];
            $userId = $data['user_id'];
    
            // Vérification que le token correspond à celui de la session
            if ($session->get('token') !== $token || $session->get('user_id') !== $userId) {
                return new JsonResponse(['message' => 'Token ou identifiant utilisateur incorrect'], 401);
            }
    
            // Supprimer les informations de session
            $session->remove('token');
            $session->remove('user_id');
    
            return new JsonResponse(['message' => 'Déconnexion réussie'], 200);
        }
    
       
}


