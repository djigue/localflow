<?php

namespace App\Repository;

use App\Entity\Messages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MessagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Messages::class);
    }

    // Méthode pour sauvegarder un message (peut être personnalisée si besoin)
    public function save(Messages $message, bool $flush = false): void
    {
        $this->_em->persist($message);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
