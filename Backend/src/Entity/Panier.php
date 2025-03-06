<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?produits $produit = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?services $service = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    private ?promotions $promotion = null;

    #[ORM\Column]
    private ?int $quantite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateur(): ?utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getProduit(): ?produits
    {
        return $this->produit;
    }

    public function setProduit(?produits $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getService(): ?services
    {
        return $this->service;
    }

    public function setService(?services $service): static
    {
        $this->service = $service;

        return $this;
    }

    public function getPromotion(): ?promotions
    {
        return $this->promotion;
    }

    public function setPromotion(?promotions $promotion): static
    {
        $this->promotion = $promotion;

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
}
