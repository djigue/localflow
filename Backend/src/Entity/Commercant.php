<?php

namespace App\Entity;

use App\Repository\CommercantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\CommercantAdresse;
use App\Entity\CommerceCommercant;

#[ORM\Entity(repositoryClass: CommercantRepository::class)]
class Commercant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $createdAt = null;

    // Relation avec CommercantAdresse (table intermédiaire)
    #[ORM\OneToMany(mappedBy: "commercant", targetEntity: CommercantAdresse::class, cascade: ["persist", "remove"])]
    private Collection $commercantAdresses;

    // Relation avec CommerceCommercant (autre table intermédiaire)
    #[ORM\OneToMany(mappedBy: "commercant", targetEntity: CommerceCommercant::class, cascade: ["persist", "remove"])]
    private Collection $commerceRelations;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->commercantAdresses = new ArrayCollection();
        $this->commerceRelations = new ArrayCollection();
    }

    // Getters et setters

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;
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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;
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

    /**
     * @return Collection<int, CommercantAdresse>
     */
    public function getCommercantAdresses(): Collection
    {
        return $this->commercantAdresses;
    }

    public function addCommercantAdresse(CommercantAdresse $commercantAdresse): self
    {
        if (!$this->commercantAdresses->contains($commercantAdresse)) {
            $this->commercantAdresses->add($commercantAdresse);
            $commercantAdresse->setCommercant($this);
        }

        return $this;
    }

    public function removeCommercantAdresse(CommercantAdresse $commercantAdresse): self
    {
        if ($this->commercantAdresses->removeElement($commercantAdresse)) {
            if ($commercantAdresse->getCommercant() === $this) {
                $commercantAdresse->setCommercant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommerceCommercant>
     */
    public function getCommerceRelations(): Collection
    {
        return $this->commerceRelations;
    }

    public function addCommerceRelation(CommerceCommercant $commerceCommercant): self
    {
        if (!$this->commerceRelations->contains($commerceCommercant)) {
            $this->commerceRelations->add($commerceCommercant);
            $commerceCommercant->setCommercant($this);
        }

        return $this;
    }

    public function removeCommerceRelation(CommerceCommercant $commerceCommercant): self
    {
        if ($this->commerceRelations->removeElement($commerceCommercant)) {
            if ($commerceCommercant->getCommercant() === $this) {
                $commerceCommercant->setCommercant(null);
            }
        }

        return $this;
    }
}
