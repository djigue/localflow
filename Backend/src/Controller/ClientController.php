<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\ImagesProduits;
use App\Entity\ImagesPromotions;
use App\Entity\ImagesServices;
use App\Entity\promotions;
use App\Entity\Services;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse; // Importation manquante
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

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

    #[Route('/api/services', name: 'api_produits', methods: ['GET'])]
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
        $promotionsRepository = $em->getRepository(promotions::class);

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
}
