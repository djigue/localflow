<?php

namespace App\Controller;

use App\Entity\Promotions;
use App\Entity\Produits;
use App\Entity\ImagesPromotions;
use App\Repository\CommercesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

final class PromotionsController extends AbstractController
{
    #[Route('/api/promotion/creation', name: 'api_promotion_creation', methods: ['POST'])]
    public function creerPromotion(Request $request, EntityManagerInterface $em): JsonResponse
{
    error_log(print_r($request->request->all(), true));

    // Récupérer les données POST (hors fichiers)
    $nom = $request->request->get('nom');
    $slug = $request->request->get('slug');
    $description = $request->request->get('description');
    $dateDebut = $request->request->get('dateDebut');
    $dateFin = $request->request->get('dateFin');
    $reduction = $request->request->get('reduction');
    $formatReduction = $request->request->get('formatReduction');


    $promotion = new Promotions();

     $nouveauPrix = 1.2;

    //     if ($formatReduction === '%'){
    //       $nouveauPrix = $promotion->getProduit()->getPrix() * (1 - $reduction/100);
    //     }else {
    //       $nouveauPrix = $promotion->getProduit()->getPrix() - $reduction;
    //     }
    
    // $nouveauPrix = max(0, $nouveauPrix);

    // $produit = $em->getRepository(Produits::class)->find($produitId);
    // if (!$produit) {
    //     return new JsonResponse(['message' => 'produit non trouvé'], 400);
    // }

    
    $promotion->setNom($nom);
    $promotion->setSlug($slug);
    $promotion->setDescription($description);
    $promotion->setDateDebut(new \DateTime($dateDebut));
    $promotion->setDateFin(new \DateTime($dateFin));
    $promotion->setReduction($reduction);
    $promotion->setFormatReduction($formatReduction);
    $promotion->setNouveauPrix($nouveauPrix);
    
    $em->persist($promotion);
    $em->flush();

    // Gestion des images
    $images = $request->files->get('images');
    if ($images) {
        $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/promotion_images';
        $filesystem = new Filesystem();

        if (!$filesystem->exists($uploadDirectory)) {
            $filesystem->mkdir($uploadDirectory, 0777);
        }

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $filename = uniqid() . '.' . $image->guessExtension();
                $image->move($uploadDirectory, $filename);

                $imageEntity = new ImagesPromotions();
                $imageEntity->setNom($filename);
                $imageEntity->setUrl('/uploads/produit_images/' . $filename);
                $imageEntity->setPromotion($promotion);
                $em->persist($imageEntity);
            }
        }
        $em->flush();
    }

    return new JsonResponse([
        'success' => true,
        'message' => 'Promotion créé avec succès !',
    ]);
}
}