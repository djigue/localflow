<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\PaniersServices;
use App\Entity\ImagesServices;
use App\Entity\Services;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class PaniersServicesController extends AbstractController
{
    #[Route('/api/panier/ajoutService/{id}', name: 'api_panier_ajout_service', methods: ['POST'])]
    public function ajouterService(int $id, Request $request, ServicesRepository $serviceRepository, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $service = $serviceRepository->find($id);

        if (!$service) {
            return new JsonResponse(['error' => 'Service non trouvé'], 404);
        }

        $quantite = $data['quantite'];
        $panier = $em->getRepository(PaniersServices::class)->findOneBy([
            'utilisateur' => $data['utilisateurId'],
            'service' => $service,
        ]);

        if ($panier) {
            $panier->setQuantité($quantite);
        } else { 
        $panier = new PaniersServices();
        $panier->setUtilisateur($data['utilisateurId']);  
        $panier->setService($service);
        $panier->setQuantite($quantite);
        $em->persist($panier);
        $em->flush();
        }

        return new JsonResponse(['message' => 'Service ajouté au panier'], 200);
    }

    #[Route('/panier/supService/{id}', name: 'supprimer_service_du_panier', methods: ['DELETE'])]
    public function supprimerServicePanier(int $id, Request $request, EntityManagerInterface $em): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        
        $panier = $em->getRepository(PaniersServices::class)->findOneBy([
            'utilisateur' => $data['utilisateurId'],
            'service' => $id,
        ]);

        if (!$panier) {
            return new JsonResponse(['message' => 'Service non trouvé dans le panier'], 404);
        }

        $em->remove($panier);
        $em->flush();

        return new JsonResponse(['message' => 'Service supprimé du panier'], 200);
    }
}