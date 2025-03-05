<?php

namespace App\Controller;

use App\Entity\Produits;
use App\Entity\Commerces;
use App\Entity\ImagesProduits;
use App\Repository\CommercesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

final class ProduitsController extends AbstractController
{
    #[Route('/api/produit/creation', name: 'api_produit_creation', methods: ['POST'])]
    public function creerProduit(Request $request, EntityManagerInterface $em): JsonResponse
{
    error_log(print_r($request->request->all(), true));

    // Récupérer les données POST (hors fichiers)
    $nom = $request->request->get('nom');
    $slug = $request->request->get('slug');
    $description = $request->request->get('description');
    $quantite = (int) $request->request->get('quantite');
    $alerte = (int) $request->request->get('alerte');
    $taille = $request->request->get('taille') ?? 'Null';
    $prix = (float) $request->request->get('prix');
    $formatPrix = $request->request->get('formatPrix');
    $commerceId = $request->request->get('commerce_id');

    $commerce = $em->getRepository(Commerces::class)->find($commerceId);
    if (!$commerce) {
        return new JsonResponse(['message' => 'Commerce non trouvé'], 400);
    }

    $produit = new Produits();
    $produit->setNom($nom);
    $produit->setDescription($description);
    $produit->setTaille($taille);
    $produit->setSlug($slug);
    $produit->setDescription($description);
    $produit->setPrix($prix);
    $produit->setQuantite($quantite);
    $produit->setCommerce($commerce);
    $produit->setAlerte($alerte);
    $produit->setStatut('en attente');
    $produit->setFormatPrix($formatPrix);

    $em->persist($produit);
    $em->flush();

    // Gestion des images
    $images = $request->files->get('images');
    if ($images) {
        $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/produit_images';
        $filesystem = new Filesystem();

        if (!$filesystem->exists($uploadDirectory)) {
            $filesystem->mkdir($uploadDirectory, 0777);
        }

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $filename = uniqid() . '.' . $image->guessExtension();
                $image->move($uploadDirectory, $filename);

                $imageEntity = new ImagesProduits();
                $imageEntity->setNom($filename);
                $imageEntity->setUrl('/uploads/produit_images/' . $filename);
                $imageEntity->setProduit($produit);
                $em->persist($imageEntity);
            }
        }
        $em->flush();
    }

    return new JsonResponse([
        'success' => true,
        'message' => 'Commerce créé avec succès !',
    ]);
}
}