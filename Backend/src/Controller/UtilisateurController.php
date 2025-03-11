<?php

namespace App\Controller;

use App\Entity\Adresses;
use App\Entity\CodesPostaux;
use App\Entity\Utilisateur;
use App\Entity\Produits;
use App\Entity\Commerces;
use App\Entity\Services;
use App\Entity\ImagesCommerces;
use App\Entity\ImagesProduits;
use App\Entity\ImagesServices;
use App\Entity\Villes;
use App\Entity\Horaires;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


final class UtilisateurController extends AbstractController
{
    #[Route('/api/utilisateur/inscription', name: 'api_utilisateur_inscription', methods: ['POST'])]
    public function signup(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
       
        $codePostal = $em->getRepository(CodesPostaux::class)->findOneBy(['numero' => $data['cp']]);
        
        if (!$codePostal) {
            return new JsonResponse(['message' => 'Code postal invalide'], 400);
        }

        $ville = $em->getRepository(Villes::class)->findOneBy(['nom' => $data['ville']]);

        if (!$ville) {
            $ville = new Villes();
            $ville->setNom($data['ville']);
            $ville->setCpId($codePostal);
            $em->persist($ville);
            $em->flush();
        }

        $adresse = new Adresses();
        $adresse->setNumero($data['numero']);
        $adresse->setRue($data['rue']);
        $adresse->setVillesId($ville);
        $em->persist($adresse);
        $em->flush();
        
        $dateNaissance = \DateTime::createFromFormat('Y-m-d', $data['date_naissance']);
        // $role = isset($data['roles']) ? $data['roles'] : 'client';

        $utilisateur = new Utilisateur();
        $utilisateur->setcivilite($data['civilite']);
        $utilisateur->setNom($data['nom']);
        $utilisateur->setPrenom($data['prenom']);
        $utilisateur->setPseudo($data['pseudo']);
        $utilisateur->setDateNaissance($dateNaissance);
        $utilisateur->setEmail($data['email']);
        $utilisateur->setTelephone($data['telephone']);
        $utilisateur->setAdresseId($adresse);
        $utilisateur->setRole($data['roles']);
        $utilisateur->setDateInscription(new \DateTime());
        $utilisateur->setAmbassadeur(false);
        $utilisateur->setExperience(0);
        
        // Hachage du mot de passe
        $hashedPassword = $passwordHasher->hashPassword($utilisateur, $data['password']);
        $utilisateur->setPassword($hashedPassword);

        
// Vérification si c'est le premier utilisateur pour devenir admin
$existingAdmin = $em->getRepository(Utilisateur::class)->findOneBy(['role' => 'admin']);
if (!$existingAdmin) {
    $utilisateur->setRole('admin');  // Si aucun admin n'existe, le premier inscrit devient admin
}

        $em->persist($utilisateur);
        $em->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], 201);
    }


    #[Route('/api/utilisateur/connexion', name: 'api_utilisateur_connexion', methods: ['POST'])]
    public function connexion(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher, SessionInterface $session): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'])) {
            return new JsonResponse(['error' => 'Données incomplètes'], 400);
        }

        $user = $em->getRepository(Utilisateur::class)->findOneBy(['email' => $data['email']]);

        if (!$user || !$passwordHasher->isPasswordValid($user, $data['password'])) {
            return new JsonResponse(['error' => 'Identifiants incorrects'], 401);
        }

        $token = bin2hex(random_bytes(32));

        // Stockage en session
        $session->set('token', $token);
        $session->set('user_id', $user->getId());
        $session->set('user_email', $user->getEmail());
        $session->set('user_role', $user->getRole());

        $commerce_id = null;
        
        if ($user -> getRole() === 'commercant'){
            $commerce_id = $user-> getCommerceIds();
        }
        
        return new JsonResponse([
            'message' => 'Connexion réussie',
            'token' => $token,
            'user_id' => $user->getId(),
            'user_email'=> $user->getEmail(),
            'user_role'=> $user->getRole(),
            'user_commerce' => $commerce_id
        ], 200);
    }

    #[Route('/api/utilisateur/deconnexion', name: 'api_utilisateur_deconnexion', methods: ['POST'])]
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
            $session->remove('user_email');
            $session->remove('user_role');
    
            return new JsonResponse(['message' => 'Déconnexion réussie'], 200);
        }
    
        #[Route('/api/commercant/{id}', name: 'api_commercant_details', methods: ['GET'])]
        public function getCommercantDetails(int $id, EntityManagerInterface $em): JsonResponse
        {
            $commercant = $em->getRepository(Utilisateur::class)->find($id);
        
            if (!$commercant) {
                return new JsonResponse(['message' => 'Utilisateur non trouvé'], 404);
            }
        
            // Vérifier si c'est un commerçant
            if (!in_array('ROLE_COMMERCANT', $commercant->getRoles())) {
                return new JsonResponse(['message' => 'Accès refusé'], 403);
            }
        
            // Récupérer les commerces du commerçant
            $commerces = $em->getRepository(Commerces::class)->findBy(['commercant' => $commercant]);
        
            $commerceData = [];
        
            foreach ($commerces as $commerce) {
                // Récupérer les images du commerce
                $imagesCommerce = $em->getRepository(ImagesCommerces::class)->findBy(['commerce' => $commerce]);
                $imagesCommerceUrls = array_map(fn($image) => $image->getUrl(), $imagesCommerce);
        
                // Récupérer les produits et leurs images
                $produits = $em->getRepository(Produits::class)->findBy(['commerce' => $commerce]);
                $produitsData = array_map(function ($produit) use ($em) {
                    $imagesProduit = $em->getRepository(ImagesProduits::class)->findBy(['produit' => $produit]);
                    return [
                        'id' => $produit->getId(),
                        'nom' => $produit->getNom(),
                        'slug' => $produit->getSlug(),
                        'prix' => $produit->getPrix(),
                        'formatPrix' => $produit->getFormatPrix(),
                        'images' => array_map(fn($image) => $image->getUrl(), $imagesProduit),
                    ];
                }, $produits);
        
                // Récupérer les services et leurs images
                $services = $em->getRepository(Services::class)->findBy(['commerce' => $commerce]);
                $servicesData = array_map(function ($service) use ($em) {
                    $imagesService = $em->getRepository(ImagesServices::class)->findBy(['service' => $service]);
                    return [
                        'id' => $service->getId(),
                        'nom' => $service->getNom(),
                        'slug' => $service->getSlug(),
                        'prix' => $service->getPrix(),
                        'images' => array_map(fn($image) => $image->getUrl(), $imagesService),
                    ];
                }, $services);

                $horaires = $em->getRepository(Horaires::class)->findBy(['commerce' => $commerce]);
                $horairesData = array_map(function ($horaire) use ($em) {
                    return [
                        'jour' => $horaire->getJour(),
                        'ouverture' => $horaire->getOuverture(),
                        'fermeture' => $horaire->getFermeture(),
                    ];
                }, $horaires);
        
                $commerceData[] = [
                    'id' => $commerce->getId(),
                    'nom' => $commerce->getNom(),
                    'telephone' => $commerce->getTelephone(),
                    'description' => $commerce->getDescription(),
                    'horaires' => $horairesData,
                    'images' => $imagesCommerceUrls,
                    'produits' => $produitsData,
                    'services' => $servicesData,
                ];
            }
        
            return new JsonResponse([
                'id' => $commercant->getId(),
                'email' => $commercant->getEmail(),
                'commerces' => $commerceData,
            ]);
        }
}
