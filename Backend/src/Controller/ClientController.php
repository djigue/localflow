<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Promotions;
use App\Entity\Services;
use App\Entity\ImagesProduits;
use App\Entity\ImagesPromotions;
use App\Entity\ImagesServices;
use App\Repository\PaniersProduitsRepository;
use App\Repository\PaniersPromotionsRepository;
use App\Repository\PaniersServicesRepository;
use App\Repository\CommercesRepository;
use App\Repository\ProduitsRepository;
use App\Repository\PromotionsRepository;
use App\Repository\ServicesRepository;
use App\Repository\EvenementsRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; 
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Connection;

class ClientController extends AbstractController
{
    #[Route('/api/produits', name: 'api_produits', methods: ['GET'])]
    public function getProduits(EntityManagerInterface $em): JsonResponse
    {
        $produitsRepository = $em->getRepository(Produits::class);

        $produits = $produitsRepository->findAll();

        $data = [];
        foreach ($produits as $produit) {
            $image = $em->getRepository(ImagesProduits::class)
                        ->findOneBy(['produit' => $produit]);

            $data[] = [
                'id' => $produit->getId(),
                'nom' => $produit->getNom(),
                'slug' => $produit->getSlug(),
                'taille' => $produit->getTaille(),
                'prix' => $produit->getPrix(),
                'formatPrix' => $produit->getFormatPrix(),
                'quantite' => $produit->getQuantite(),
                'image' => $image ? $image->getUrl() : null,  
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/services', name: 'api_services', methods: ['GET'])]
    public function getServices(EntityManagerInterface $em): JsonResponse
    {
        $servicesRepository = $em->getRepository(Services::class);

        $services = $servicesRepository->findAll();

        $data = [];
        foreach ($services as $service) {
            $image = $em->getRepository(ImagesServices::class)
                        ->findOneBy(['service' => $service]);

            $data[] = [
                'id' => $service->getId(),
                'nom' => $service->getNom(),
                'slug' => $service->getSlug(),
                'prix' => $service->getPrix(),
                'duree' => $service->getDuree(),
                'reservation' => $service->isReservation(),
                'image' => $image ? $image->getUrl() : null,  
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('/api/promotions', name: 'api_promotions', methods: ['GET'])]
    public function getPromotions(EntityManagerInterface $em): JsonResponse
    {
        $promotionsRepository = $em->getRepository(Promotions::class);

        $promotions = $promotionsRepository->findAll();

        $data = [];
        foreach ($promotions as $promotion) {
            $image = $em->getRepository(ImagesPromotions::class)
                        ->findOneBy(['promotion' => $promotion]);

            $data[] = [
                'id' => $promotion->getId(),
                'nom' => $promotion->getNom(),
                'slug' => $promotion->getSlug(),
                'prix' => $promotion->getNouveauPrix(),
                'dateDebut' => $promotion->getDateDebut(),
                'datefin' => $promotion->getDateFin(),
                'image' => $image ? $image->getUrl() : null,  
            ];
        }

        return new JsonResponse($data);
    }

    #[Route('api/panier/{userId}', name: 'panier_user', methods: ['GET'])]
    public function getPanier(int $userId, PaniersProduitsRepository $paniersProduitsRepository,
                PaniersPromotionsRepository $paniersPromotionsRepository, PaniersservicesRepository $paniersServicesRepository): JsonResponse
    {
        $panierProduit = $paniersProduitsRepository->getPanierProduit($userId);
        $panierPromotion = $paniersPromotionsRepository->getPanierPromotion($userId);
        $panierService = $paniersServicesRepository->getPanierService($userId);

        if (empty($panierProduit) && empty($panierPromotion) && empty($panierService)) {
            return new JsonResponse(['message' => 'Le panier est vide.']);
        }
    
        return new JsonResponse([
            'produits' => $panierProduit ?? [],
            'promotions' => $panierPromotion ?? [],
            'services' => $panierService ?? []
        ]);
    }

    #[Route('api/acceuilClient/{userId}', name: 'acceuil_client', methods: ['GET'])]
    public function acceuilClient(int $userId, Connection $connection, UtilisateurRepository $ur): JsonResponse
    {
        // Récupérer l'utilisateur
        $user = $ur->find($userId);
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Requêtes SQL pures
        $commerces = $connection->fetchAllAssociative("
            SELECT c.id AS commerceId, c.nom, i.url AS image
            FROM commerces c
            LEFT JOIN images_commerces i ON i.commerce_id = c.id
            WHERE i.id = (SELECT MIN(i2.id) FROM images_commerces i2 WHERE i2.commerce_id = c.id)
            ORDER BY RAND()
            LIMIT 5
        ");

        $produits = $connection->fetchAllAssociative("
            SELECT p.id AS produitId, p.nom, i.url AS image
            FROM produits p
            LEFT JOIN images_produits i ON i.produit_id = p.id
            WHERE i.id = (SELECT MIN(i2.id) FROM images_produits i2 WHERE i2.produit_id = p.id)
            ORDER BY RAND()
            LIMIT 5
        ");

        $promotions = $connection->fetchAllAssociative("
            SELECT pr.id AS promotionId, pr.nom, i.url AS image
            FROM promotions pr
            LEFT JOIN images_promotions i ON i.promotion_id = pr.id
            WHERE i.id = (SELECT MIN(i2.id) FROM images_promotions i2 WHERE i2.promotion_id = pr.id)
            ORDER BY RAND()
            LIMIT 5
        ");

        $services = $connection->fetchAllAssociative("
            SELECT s.id AS serviceId, s.nom, i.url AS image
            FROM services s
            LEFT JOIN images_services i ON i.service_id = s.id
            WHERE i.id = (SELECT MIN(i2.id) FROM images_services i2 WHERE i2.service_id = s.id)
            ORDER BY RAND()
            LIMIT 5
        ");

        $evenements = $connection->fetchAllAssociative("
            SELECT e.id AS evenementId, e.nom, i.url AS image
            FROM evenements e
            LEFT JOIN images_evenements i ON i.evenement_id = e.id
            WHERE i.id = (SELECT MIN(i2.id) FROM images_evenements i2 WHERE i2.evenement_id = e.id)
            ORDER BY RAND()
            LIMIT 5
        ");

        // Retourner les données en JSON
        return new JsonResponse([
            'prenom' => $user->getPrenom(),
            'commerces' => $commerces ?? [],
            'produits' => $produits ?? [],
            'promotions' => $promotions ?? [],
            'services' => $services ?? [],
            'evenements' => $evenements ?? []
        ]);
    }
}

