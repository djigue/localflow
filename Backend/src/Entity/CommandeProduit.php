<?php

namespace App\Entity;

use App\Repository\CommandeProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Commande;
use App\Entity\Produit;

#[ORM\Entity(repositoryClass: CommandeProduitRepository::class)]
class CommandeProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\ManyToOne(targetEntity: Commande::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commande $commande = null;
    
    #[ORM\ManyToOne(targetEntity: Produit::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Produit $produit = null;
    
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
    
    // ------------------- GETTERS & SETTERS ------------------- //
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getCommande(): ?Commande
    {
        return $this->commande;
    }
    
    public function setCommande(?Commande $commande): static
    {
        $this->commande = $commande;
        return $this;
    }
    
    public function getProduit(): ?Produit
    {
        return $this->produit;
    }
    
    public function setProduit(?Produit $produit): static
    {
        $this->produit = $produit;
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
    
    // Mise à jour : le getter retourne bien une string
    public function getPrixUnitaire(): ?string
    {
        return $this->prixUnitaire;
    }
    
    // Le setter attend désormais une string
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
