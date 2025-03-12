<?php

namespace App\Entity;

use App\Repository\PromotionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionsRepository::class)]
class Promotions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column]
    private ?int $reduction = null;

    #[ORM\Column(length: 5)]
    private ?string $format_reduction = null;

    #[ORM\Column]
    private ?float $nouveau_prix = null;

    #[ORM\ManyToOne(inversedBy: 'promotions')]
    private ?Produits $produit = null;

    #[ORM\ManyToOne(inversedBy: 'promotions')]
    private ?Services $service = null;

    /**
     * @var Collection<int, ImagesPromotions>
     */
    #[ORM\OneToMany(targetEntity: ImagesPromotions::class, mappedBy: 'promotion')]
    private Collection $imagesPromotions;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'promotion')]
    private Collection $paniers;

    /**
     * @var Collection<int, PaniersPromotions>
     */
    #[ORM\OneToMany(targetEntity: PaniersPromotions::class, mappedBy: 'promotion', orphanRemoval: true)]
    private Collection $paniersPromotions;

    public function __construct()
    {
        $this->imagesPromotions = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->paniersPromotions = new ArrayCollection();
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

    public function setSlug(?string $slug): static
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(?\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(?\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getReduction(): ?int
    {
        return $this->reduction;
    }

    public function setReduction(int $reduction): static
    {
        $this->reduction = $reduction;

        return $this;
    }

    public function getFormatReduction(): ?string
    {
        return $this->format_reduction;
    }

    public function setFormatReduction(string $format_reduction): static
    {
        $this->format_reduction = $format_reduction;

        return $this;
    }

    public function getNouveauPrix(): ?float
    {
        return $this->nouveau_prix;
    }

    public function setNouveauPrix(float $nouveau_prix): static
    {
        $this->nouveau_prix = $nouveau_prix;

        return $this;
    }

    public function getProduit(): ?Produits
    {
        return $this->produit;
    }

    public function setProduit(?Produits $produit): static
    {
        $this->produit = $produit;

        return $this;
    }

    public function getService(): ?Services
    {
        return $this->service;
    }

    public function setService(?Services $service): static
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection<int, ImagesPromotions>
     */
    public function getImagesPromotions(): Collection
    {
        return $this->imagesPromotions;
    }

    public function addImagesPromotion(ImagesPromotions $imagesPromotion): static
    {
        if (!$this->imagesPromotions->contains($imagesPromotion)) {
            $this->imagesPromotions->add($imagesPromotion);
            $imagesPromotion->setPromotion($this);
        }

        return $this;
    }

    public function removeImagesPromotion(ImagesPromotions $imagesPromotion): static
    {
        if ($this->imagesPromotions->removeElement($imagesPromotion)) {
            // set the owning side to null (unless already changed)
            if ($imagesPromotion->getPromotion() === $this) {
                $imagesPromotion->setPromotion(null);
            }
        }

        return $this;
    }

    public function setImage(?string $image): self
    {
        $firstImage = $this->imagesPromotions->first();

        if ($firstImage) {
            $firstImage->setUrl($image);
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
            $panier->setPromotion($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getPromotion() === $this) {
                $panier->setPromotion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PaniersPromotions>
     */
    public function getPaniersPromotions(): Collection
    {
        return $this->paniersPromotions;
    }

    public function addPaniersPromotion(PaniersPromotions $paniersPromotion): static
    {
        if (!$this->paniersPromotions->contains($paniersPromotion)) {
            $this->paniersPromotions->add($paniersPromotion);
            $paniersPromotion->setPromotion($this);
        }

        return $this;
    }

    public function removePaniersPromotion(PaniersPromotions $paniersPromotion): static
    {
        if ($this->paniersPromotions->removeElement($paniersPromotion)) {
            // set the owning side to null (unless already changed)
            if ($paniersPromotion->getPromotion() === $this) {
                $paniersPromotion->setPromotion(null);
            }
        }

        return $this;
    }
}
