<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\PanierService;
use App\Entity\PanierProduit;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: "panier", targetEntity: PanierService::class, cascade: ["persist", "remove"])]
    private Collection $services;

    #[ORM\OneToMany(mappedBy: "panier", targetEntity: PanierProduit::class, cascade: ["persist", "remove"])]
    private Collection $produits;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->services = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, PanierService>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(PanierService $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setPanier($this);
        }

        return $this;
    }

    public function removeService(PanierService $service): self
    {
        if ($this->services->removeElement($service)) {
            if ($service->getPanier() === $this) {
                $service->setPanier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PanierProduit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(PanierProduit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setPanier($this);
        }

        return $this;
    }

    public function removeProduit(PanierProduit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            if ($produit->getPanier() === $this) {
                $produit->setPanier(null);
            }
        }

        return $this;
    }
}
