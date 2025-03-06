<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\PaniersPromotions;
use App\Entity\ImagesPromotions;
use App\Entity\Promotions;
use App\Repository\PromotionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class PaniersPromotionsController extends AbstractController
{
    #[Route('/api/panier/ajoutPromotion/{id}', name: 'api_panier_ajout_promotion', methods: ['POST'])]
    public function ajouterPromotion(int $id, Request $request, PromotionsRepository $promotionRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $promotion = $promotionRepository->find($id);

        if (!$promotion) {
            return new JsonResponse(['error' => 'Promotion non trouvé'], 404);
        }

        $quantite = $data['quantite'] ?? 1; 
        $panier = $em->getRepository(PaniersPromotions::class)->findOneBy([
            'utilisateur' => $data['utilisateurId'],
            'service' => $promotion,
        ]);

        if ($panier) {
            $panier->setQuantité($quantite);
        } else { 
            $panier = new PaniersPromotions();
            $panier->setUtilisateur($data['utilisateurId']);
            $panier->setPromotion($promotion);
            $panier->setQuantite($quantite);
        }
            $em->persist($panier);
            $em->flush();

        return new JsonResponse(['message' => 'Promotion ajoutée au panier'], 200);
    }

    #[Route('/panier/supPromomotion/{id}', name: 'supprimer_promotion_du_panier', methods: ['DELETE'])]
    public function supprimerPromomotionPanier(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        
        $panier = $em->getRepository(PaniersPromotions::class)->findOneBy([
            'utilisateur' => $data['utilisateurId'],
            'promotion' => $id,
        ]);

        if (!$panier) {
            return new JsonResponse(['message' => 'Promotion non trouvée dans le panier'], 404);
        }

        $em->remove($panier);
        $em->flush();

        return new JsonResponse(['message' => 'Promotion supprimée du panier'], 200);
    }
}