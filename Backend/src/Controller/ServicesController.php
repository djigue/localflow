<?php

namespace App\Controller;

use App\Entity\Services;
use App\Entity\Commerces;
use App\Entity\ImagesServices;
use App\Repository\CommercesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

final class ServicesController extends AbstractController
{
    #[Route('/api/service/creation', name: 'api_service_creation', methods: ['POST'])]
    public function creerProduit(Request $request, EntityManagerInterface $em): JsonResponse
{
    error_log(print_r($request->request->all(), true));

    // Récupérer les données POST (hors fichiers)
    $nom = $request->request->get('nom');
    $slug = $request->request->get('slug');
    $description = $request->request->get('description');
    $duree = $request->request->get('duree');
    $reservation = $request->request->get('reservation');
    $prix = $request->request->get('prix');
    $commerceId = $request->request->get('commerce_id');

    $commerce = $em->getRepository(Commerces::class)->find($commerceId);
    if (!$commerce) {
        return new JsonResponse(['message' => 'Commerce non trouvé'], 400);
    }

    $service = new Services();
    $service->setNom($nom);
    $service->setSlug($slug);
    $service->setDescription($description);
    $service->setDuree($duree);
    $service->setReservation($reservation);
    $service->setPrix($prix);
    $service->setCommerce($commerce);

    $em->persist($service);
    $em->flush();

    // Gestion des images
    $images = $request->files->get('images');
    if ($images) {
        $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/service_images';
        $filesystem = new Filesystem();

        if (!$filesystem->exists($uploadDirectory)) {
            $filesystem->mkdir($uploadDirectory, 0777);
        }

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $filename = uniqid() . '.' . $image->guessExtension();
                $image->move($uploadDirectory, $filename);

                $imageEntity = new ImagesServices();
                $imageEntity->setNom($filename);
                $imageEntity->setUrl('/uploads/service_images/' . $filename);
                $imageEntity->setService($service);
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