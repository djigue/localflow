<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\PaniersProduits;
use App\Entity\ImagesProduits;
use App\Repository\ProduitsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class PaniersProduitsController extends AbstractController
{
    #[Route('/api/panier/ajoutProduit/{id}', name: 'api_panier_ajout_produit', methods: ['POST'])]
    public function ajouterProduit(int $id, Request $request, ProduitsRepository $produitsRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $produit = $produitsRepository->find($id);

        if (!$produit) {
            return new JsonResponse(['error' => 'Produit non trouvé'], 404);
        }

        $quantite = $data['quantite']; 
        $panier = $em->getRepository(PaniersProduits::class)->findOneBy([
            'utilisateur' => $data['utilisateurId'],
            'produit' => $produit,
        ]);

        if ($panier) {
            $panier->setQuantité($quantite);
        } else {
            $panier = new PaniersProduits();
            $panier->setUtilisateur($data['utilisateurId']);  
            $panier->setProduit($produit);
            $panier->setQuantite($quantite);
        }
            $em->persist($panier);
            $em->flush();
        

        return new JsonResponse(['message' => 'Produit ajouté au panier'], 200);
    }

    #[Route('/panier/supProduit/{id}', name: 'supprimer_produit_du_panier', methods: ['DELETE'])]
    public function supprimerProduitPanier(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        
        $panier = $em->getRepository(PaniersProduits::class)->findOneBy([
            'utilisateur' => $data['utilisateurId'],
            'produit' => $id,
        ]);

        if (!$panier) {
            return new JsonResponse(['message' => 'Produit non trouvé dans le panier'], 404);
        }

        $em->remove($panier);
        $em->flush();

        return new JsonResponse(['message' => 'Produit supprimé du panier'], 200);
    }

}