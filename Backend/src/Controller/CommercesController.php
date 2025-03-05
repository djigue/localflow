<?php

namespace App\Controller;

use App\Entity\Commerces;
use App\Entity\Utilisateur;
use App\Entity\Adresses;
use App\Entity\CodesPostaux;
use App\Entity\Evenements;
use App\Entity\Villes;
use App\Entity\Horaires;
use App\Entity\ImagesCommerces;
use App\Entity\ImagesEvenements;
use App\Repository\CommercesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;

//#[Route('/commerces')]
final class CommercesController extends AbstractController
{
    #[Route('/api/commerce/creation', name: 'api_commerce_creation', methods: ['POST'])]
    public function creerCommerce(Request $request, EntityManagerInterface $em): JsonResponse
{
    // Récupérer les données POST (hors fichiers)
    $nom = $request->request->get('nom');
    $siret = (int) $request->request->get('siret');
    $secteurActivite = $request->request->get('secteur_activite');
    $fixe = $request->request->get('fixe');
    $slug = $request->request->get('slug');
    $description = $request->request->get('description');
    $livraison = $request->request->get('livraison');
    $lien = $request->request->get('lien');
    $horaireJson = $request->request->get('horaire');
    $horaire = json_decode($horaireJson, true);
    $telephone = $request->request->get('telephone');
    $numero = $request->request->get('numero');
    $rue = $request->request->get('rue');
    $cp = $request->request->get('cp');
    $ville = $request->request->get('ville');
    $userId = $request->request->get('user_id');

    // Vérification du commerce existant
    $commerceExist = $em->getRepository(Commerces::class)->findOneBy(['siret' => $siret]);
    if ($commerceExist) {
        return new JsonResponse(['message' => 'Ce commerce existe déjà'], 400);
    }

    $user = $em->getRepository(Utilisateur::class)->find($userId);
    if (!$user) {
        return new JsonResponse(['message' => 'Utilisateur non trouvé'], 400);
    }

    $codePostal = $em->getRepository(CodesPostaux::class)->findOneBy(['numero' => $cp]);
    if (!$codePostal) {
        return new JsonResponse(['message' => 'Code postal invalide'], 400);
    }

    $villeEntity = $em->getRepository(Villes::class)->findOneBy(['nom' => $ville]);
    if (!$villeEntity) {
        $villeEntity = new Villes();
        $villeEntity->setNom($ville);
        $villeEntity->setCpId($codePostal);
        $em->persist($villeEntity);
        $em->flush();
    }

    $adresse = new Adresses();
    $adresse->setNumero($numero);
    $adresse->setRue($rue);
    $adresse->setVillesId($villeEntity);
    $em->persist($adresse);
    $em->flush();

    $commerce = new Commerces();
    $commerce->setNom($nom);
    $commerce->setSiret($siret);
    $commerce->setSecteurActivite($secteurActivite);
    $commerce->setFixe($fixe);
    $commerce->setSlug($slug);
    $commerce->setDescription($description);
    $commerce->setLivraison($livraison);
    $commerce->setLien($lien);
    $commerce->addAdress($adresse);
    $commerce->setCommercant($user);
    $commerce->setTelephone($telephone);
    $commerce->setStatut('en attente');
    $commerce->setEcoResponsable(false);
    $em->persist($commerce);
    $em->flush();

    // Enregistrement des horaires
    if (is_array($horaire)) {
        foreach ($horaire as $h) {
            $horaireEntity = new Horaires();
            $horaireEntity->setCommerce($commerce);
            $horaireEntity->setJour($h['jour']);
            $horaireEntity->setOuverture($h['ouverture']);
            $horaireEntity->setFermeture($h['fermeture']);
            $em->persist($horaireEntity);
        }
        $em->flush();
    }

    // Gestion des images
    $images = $request->files->get('images');
    if ($images) {
        $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/commerce_images';
        $filesystem = new Filesystem();

        if (!$filesystem->exists($uploadDirectory)) {
            $filesystem->mkdir($uploadDirectory, 0777);
        }

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $filename = uniqid() . '.' . $image->guessExtension();
                $image->move($uploadDirectory, $filename);

                $imageEntity = new ImagesCommerces();
                $imageEntity->setNom($filename);
                $imageEntity->setUrl('/uploads/commerce_images/' . $filename);
                $imageEntity->setCommerce($commerce);
                $em->persist($imageEntity);
            }
        }
        $em->flush();
    }

    return new JsonResponse([
        'success' => true,
        'message' => 'Commerce créé avec succès !',
        'user_id' => $user->getId(),
        'commerce_id' => $commerce->getId()
    ]);
}

#[Route('/api/commerce/evenement', name: 'api_commerce_evenement', methods: ['POST'])]
    public function creerEvenement(Request $request, EntityManagerInterface $em): JsonResponse
{
    // Récupérer les données POST (hors fichiers)
    $nom = $request->request->get('nom');
    $date_debut = $request->request->get('date_debut');
    $date_fin = $request->request->get('date_fin');
    $heure_debut = $request->request->get('heure_debut');
    $heure_fin = $request->request->get('heure_fin');
    $slug = $request->request->get('slug');
    $description = $request->request->get('description');
    $inscription = $request->request->get('inscription');
    $nombre = $request->request->get('nombre');
    $alerte = $request->request->get('alerte');
    $numero = $request->request->get('numero');
    $rue = $request->request->get('rue');
    $cp = $request->request->get('cp');
    $ville = $request->request->get('ville');
    $commerce_id = $request->request->get('commerce_id');
    
    $commerce = $em->getRepository(Commerces::class)->find($commerce_id);
    if (!$commerce) {
        return new JsonResponse(['message' => 'commerce non trouvé'], 400);
    }

    $codePostal = $em->getRepository(CodesPostaux::class)->findOneBy(['numero' => $cp]);
    if (!$codePostal) {
        return new JsonResponse(['message' => 'Code postal invalide'], 400);
    }

    $villeEntity = $em->getRepository(Villes::class)->findOneBy(['nom' => $ville]);
    if (!$villeEntity) {
        $villeEntity = new Villes();
        $villeEntity->setNom($ville);
        $villeEntity->setCpId($codePostal);
        $em->persist($villeEntity);
        $em->flush();
    }

    $adresse = new Adresses();
    $adresse->setNumero($numero);
    $adresse->setRue($rue);
    $adresse->setVillesId($villeEntity);
    $em->persist($adresse);
    $em->flush();

    $evenement = new Evenements();
    $evenement->setNom($nom);
    $evenement->setDateDebut(new \DateTime($date_debut));
    $evenement->setDateFin(new \DateTime($date_fin));
    $evenement->setHeureDebut(new \DateTime($heure_debut));
    $evenement->setHeureFin(new \DateTime($heure_fin));
    $evenement->setDescription($description);
    // $evenement->setSlug($slug);
    $evenement->setInscription($inscription);
    $evenement->getAdresse($adresse);
    $evenement->setCommerce($commerce);
    $evenement->setNombreParticipant($nombre);
    $evenement->setAlerte($alerte);
    $evenement->setComplet('1');
    
    $em->persist($evenement);
    $em->flush();

    // Gestion des images
    $images = $request->files->get('images');
    if ($images) {
        $uploadDirectory = $this->getParameter('kernel.project_dir') . '/public/uploads/commerce_images';
        $filesystem = new Filesystem();

        if (!$filesystem->exists($uploadDirectory)) {
            $filesystem->mkdir($uploadDirectory, 0777);
        }

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $filename = uniqid() . '.' . $image->guessExtension();
                $image->move($uploadDirectory, $filename);

                $imageEntity = new ImagesEvenements();
                $imageEntity->setNom($filename);
                $imageEntity->setUrl('/uploads/evenement_images/' . $filename);
                $imageEntity->setEvenement($evenement);
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
};
    // #[Route('/api/commerce/afficheCommerce', name: 'api_commerce_affichage', methods: ['POST'])]
    // public function afficheCommerce(Request $request, EntityManagerInterface $em, SessionInterface $session)
    // {
    //     $commerce = new Commerces();
    //     $commerce->getNom();
    //     $commerce->getTelephone();

    //     return new JsonResponse([$commerce]);
    // }

