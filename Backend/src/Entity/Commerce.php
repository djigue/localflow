<?php

namespace App\Entity;

use App\Repository\CommerceRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Adresse;
use App\Entity\CommerceCommercant;
use App\Entity\Produit;

#[ORM\Entity(repositoryClass: CommerceRepository::class)]
class Commerce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 100)]
    private ?string $nom = null;
    
    #[ORM\Column(length: 14, unique: true)]
    private ?string $siret = null;
    
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;
    
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $secteurActivite = null;
    
    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;
    
    #[ORM\Column]
    private ?bool $ecoResponsable = false;
    
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $statut = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lien = null;
    
    #[ORM\ManyToOne(targetEntity: Adresse::class, inversedBy: "commerces")]
    #[ORM\JoinColumn(nullable: true)]
    private ?Adresse $adresse = null;
    
    #[ORM\OneToMany(mappedBy: "commerce", targetEntity: CommerceCommercant::class)]
    private Collection $commercants;
    
    #[ORM\OneToMany(mappedBy: "commerce", targetEntity: Produit::class)]
    private Collection $produits;

    public function __construct()
    {
        $this->ecoResponsable = false;
        $this->commercants = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getNom(): ?string
    {
        return $this->nom;
    }
    
    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }
    
    public function getSiret(): ?string
    {
        return $this->siret;
    }
    
    public function setSiret(string $siret): static
    {
        $this->siret = $siret;
        return $this;
    }
    
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }
    
    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
        return $this;
    }
    
    public function getSecteurActivite(): ?string
    {
        return $this->secteurActivite;
    }
    
    public function setSecteurActivite(?string $secteurActivite): static
    {
        $this->secteurActivite = $secteurActivite;
        return $this;
    }
    
    public function getDescription(): ?string
    {
        return $this->description;
    }
    
    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }
    
    public function isEcoResponsable(): ?bool
    {
        return $this->ecoResponsable;
    }
    
    public function setEcoResponsable(bool $ecoResponsable): static
    {
        $this->ecoResponsable = $ecoResponsable;
        return $this;
    }
    
    public function getStatut(): ?string
    {
        return $this->statut;
    }
    
    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }
    
    public function getLien(): ?string
    {
        return $this->lien;
    }
    
    public function setLien(?string $lien): static
    {
        $this->lien = $lien;
        return $this;
    }
    
    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }
    
    public function setAdresse(?Adresse $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }
    
    public function getCommercants(): Collection
    {
        return $this->commercants;
    }
    
    public function addCommercant(CommerceCommercant $commerceCommercant): static
    {
        if (!$this->commercants->contains($commerceCommercant)) {
            $this->commercants[] = $commerceCommercant;
            $commerceCommercant->setCommerce($this);
        }
        return $this;
    }
    
    public function removeCommercant(CommerceCommercant $commerceCommercant): static
    {
        if ($this->commercants->removeElement($commerceCommercant)) {
            if ($commerceCommercant->getCommerce() === $this) {
                $commerceCommercant->setCommerce(null);
            }
        }
        return $this;
    }

    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCommerce($this);
        }
        return $this;
    }

    public function removeProduit(Produit $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            if ($produit->getCommerce() === $this) {
                $produit->setCommerce(null);
            }
        }
        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
