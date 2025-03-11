<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class MessageController extends AbstractController
{
    private $entityManager;

    // Injecter l'EntityManagerInterface via le constructeur
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/api/messages", name="send_message", methods={"POST"})
     */
    public function sendMessage(Request $request): JsonResponse
    {
        // Récupérer les données envoyées depuis React
        $data = json_decode($request->getContent(), true);

        // Vérifier que les données sont valides
        if (empty($data['expediteur']) || empty($data['destinataire']) || empty($data['message'])) {
            return new JsonResponse(['success' => false, 'message' => 'Données manquantes.'], 400);
        }

        // Récupérer l'expéditeur et le destinataire depuis la base de données via EntityManager
        $expediteur = $this->entityManager->getRepository(Utilisateur::class)->find($data['expediteur']);
        $destinataire = $this->entityManager->getRepository(Utilisateur::class)->find($data['destinataire']);

        if (!$expediteur || !$destinataire) {
            return new JsonResponse(['success' => false, 'message' => 'Utilisateur non trouvé.'], 404);
        }

        // Créer un nouveau message
        $message = new Messages();
        $message->setExpediteur($expediteur);
        $message->setDestinataire($destinataire);
        $message->setMessage($data['message']);
        $message->setDateEnvoi(new \DateTime());

        // Enregistrer le message en base de données
        $this->entityManager->persist($message);
        $this->entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
}
