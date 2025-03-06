<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServicesRepository::class)]
class Services
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $duree = null;

    #[ORM\Column]
    private ?bool $reservation = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'services')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commerces $commerce = null;

    /**
     * @var Collection<int, ImagesServices>
     */
    #[ORM\OneToMany(targetEntity: ImagesServices::class, mappedBy: 'service', orphanRemoval: true)]
    private Collection $imagesServices;

    /**
     * @var Collection<int, Promotions>
     */
    #[ORM\OneToMany(targetEntity: Promotions::class, mappedBy: 'service')]
    private Collection $promotions;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'service')]
    private Collection $paniers;

    /**
     * @var Collection<int, PaniersServices>
     */
    #[ORM\OneToMany(targetEntity: PaniersServices::class, mappedBy: 'service', orphanRemoval: true)]
    private Collection $paniersServices;

    public function __construct()
    {
        $this->imagesServices = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->paniersServices = new ArrayCollection();
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

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(?string $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function isReservation(): ?bool
    {
        return $this->reservation;
    }

    public function setReservation(bool $reservation): static
    {
        $this->reservation = $reservation;

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
     * @return Collection<int, ImagesServices>
     */
    public function getImagesServices(): Collection
    {
        return $this->imagesServices;
    }

    public function addImagesService(ImagesServices $imagesService): static
    {
        if (!$this->imagesServices->contains($imagesService)) {
            $this->imagesServices->add($imagesService);
            $imagesService->setService($this);
        }

        return $this;
    }

    public function removeImagesService(ImagesServices $imagesService): static
    {
        if ($this->imagesServices->removeElement($imagesService)) {
            // set the owning side to null (unless already changed)
            if ($imagesService->getService() === $this) {
                $imagesService->setService(null);
            }
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
            $promotion->setService($this);
        }

        return $this;
    }

    public function removePromotion(Promotions $promotion): static
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getService() === $this) {
                $promotion->setService(null);
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
            $panier->setService($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getService() === $this) {
                $panier->setService(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PaniersServices>
     */
    public function getPaniersServices(): Collection
    {
        return $this->paniersServices;
    }

    public function addPaniersService(PaniersServices $paniersService): static
    {
        if (!$this->paniersServices->contains($paniersService)) {
            $this->paniersServices->add($paniersService);
            $paniersService->setService($this);
        }

        return $this;
    }

    public function removePaniersService(PaniersServices $paniersService): static
    {
        if ($this->paniersServices->removeElement($paniersService)) {
            // set the owning side to null (unless already changed)
            if ($paniersService->getService() === $this) {
                $paniersService->setService(null);
            }
        }

        return $this;
    }
}
