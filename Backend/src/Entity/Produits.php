<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitsRepository::class)]
class Produits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column(nullable: true)]
    private ?int $alerte = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $taille = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(length: 10)]
    private ?string $format_prix = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commerces $commerce = null;

    /**
     * @var Collection<int, ImagesProduits>
     */
    #[ORM\OneToMany(targetEntity: ImagesProduits::class, mappedBy: 'produit', orphanRemoval: true)]
    private Collection $imagesProduits;

    /**
     * @var Collection<int, Promotions>
     */
    #[ORM\OneToMany(targetEntity: Promotions::class, mappedBy: 'produit')]
    private Collection $promotions;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'produit')]
    private Collection $paniers;

    /**
     * @var Collection<int, PaniersProduits>
     */
    #[ORM\OneToMany(targetEntity: PaniersProduits::class, mappedBy: 'produit', orphanRemoval: true)]
    private Collection $paniersProduits;

    public function __construct()
    {
        $this->imagesProduits = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->paniersProduits = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

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

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getAlerte(): ?int
    {
        return $this->alerte;
    }

    public function setAlerte(?int $alerte): static
    {
        $this->alerte = $alerte;

        return $this;
    }

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(?string $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getFormatPrix(): ?string
    {
        return $this->format_prix;
    }

    public function setFormatPrix(string $format_prix): static
    {
        $this->format_prix = $format_prix;

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

    public function getCommerce(): ?Commerces
    {
        return $this->commerce;
    }

    public function setCommerce(?Commerces $commerce): static
    {
        $this->commerce = $commerce;

        return $this;
    }

    /**
     * @return Collection<int, ImagesProduits>
     */
    public function getImagesProduits(): Collection
    {
        return $this->imagesProduits;
    }

    public function addImagesProduit(ImagesProduits $imagesProduit): static
    {
        if (!$this->imagesProduits->contains($imagesProduit)) {
            $this->imagesProduits->add($imagesProduit);
            $imagesProduit->setProduit($this);
        }

        return $this;
    }

    public function removeImagesProduit(ImagesProduits $imagesProduit): static
    {
        if ($this->imagesProduits->removeElement($imagesProduit)) {
            // set the owning side to null (unless already changed)
            if ($imagesProduit->getProduit() === $this) {
                $imagesProduit->setProduit(null);
            }
        }

        return $this;
    }

    public function setImage(?string $image): self
    {
        $firstImage = $this->imagesProduits->first();

        if ($firstImage) {
            $firstImage->setUrl($image);
        }

        return $this;
    }

    /**
     * @return Collection<int, Promotions>
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotions $promotion): static
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions->add($promotion);
            $promotion->setProduit($this);
        }

        return $this;
    }

    public function removePromotion(Promotions $promotion): static
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getProduit() === $this) {
                $promotion->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): static
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setProduit($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getProduit() === $this) {
                $panier->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PaniersProduits>
     */
    public function getPaniersProduits(): Collection
    {
        return $this->paniersProduits;
    }

    public function addPaniersProduit(PaniersProduits $paniersProduit): static
    {
        if (!$this->paniersProduits->contains($paniersProduit)) {
            $this->paniersProduits->add($paniersProduit);
            $paniersProduit->setProduit($this);
        }

        return $this;
    }

    public function removePaniersProduit(PaniersProduits $paniersProduit): static
    {
        if ($this->paniersProduits->removeElement($paniersProduit)) {
            // set the owning side to null (unless already changed)
            if ($paniersProduit->getProduit() === $this) {
                $paniersProduit->setProduit(null);
            }
        }

        return $this;
    }
}
