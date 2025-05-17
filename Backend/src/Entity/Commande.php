<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;
    
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $dateCommande = null;
    
    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private ?string $montantTotal = null;
    
    #[ORM\Column(length: 50)]
    private ?string $statut = null;
    
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $createdAt = null;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    // ------------------- GETTERS & SETTERS ------------------- //
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getUser(): ?User
    {
        return $this->user;
    }
    
    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }
    
    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }
    
    public function setDateCommande(\DateTimeInterface $dateCommande): static
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }
    
    // Modification : utilisation de string pour le montantTotal
    public function getMontantTotal(): ?string
    {
        return $this->montantTotal;
    }
    
    public function setMontantTotal(string $montantTotal): static
    {
        $this->montantTotal = $montantTotal;
        return $this;
    }
    
    public function getStatut(): ?string
    {
        return $this->statut;
    }
    
    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }
    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
