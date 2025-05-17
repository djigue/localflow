<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Commercant;
use App\Entity\Adresse;

#[ORM\Entity]
class CommercantAdresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Commercant::class, inversedBy: 'commercantAdresses')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')] // Assurez une suppression en cascade
    private ?Commercant $commercant = null;

    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: 'commercantAdresses')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')] // Assurez une suppression en cascade
    private ?Adresse $adresse = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommercant(): ?Commercant
    {
        return $this->commercant;
    }

    public function setCommercant(?Commercant $commercant): self
    {
        $this->commercant = $commercant;
        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }
}
