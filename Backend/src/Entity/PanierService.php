<?php

namespace App\Entity;

use App\Repository\PanierServiceRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Panier;
use App\Entity\Service;

#[ORM\Entity(repositoryClass: PanierServiceRepository::class)]
class PanierService
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToOne(targetEntity: Panier::class, inversedBy: "services")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Panier $panier = null;
    
    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Service $service = null;
    
    #[ORM\Column(type: "integer")]
    private ?int $quantite = null;
    
    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private ?string $prixUnitaire = null;
    
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $createdAt = null;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    // Getters et Setters

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getPanier(): ?Panier
    {
        return $this->panier;
    }
    
    public function setPanier(?Panier $panier): static
    {
        $this->panier = $panier;
        return $this;
    }
    
    public function getService(): ?Service
    {
        return $this->service;
    }
    
    public function setService(?Service $service): static
    {
        $this->service = $service;
        return $this;
    }
    
    public function getQuantite(): ?int
    {
        return $this->quantite;
    }
    
    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;
        return $this;
    }
    
    public function getPrixUnitaire(): ?string
    {
        return $this->prixUnitaire;
    }
    
    public function setPrixUnitaire(string $prixUnitaire): static
    {
        $this->prixUnitaire = $prixUnitaire;
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
