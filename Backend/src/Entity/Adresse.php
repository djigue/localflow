<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: AdresseRepository::class)]
class Adresse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\ManyToOne(targetEntity: Ville::class, inversedBy: "adresses")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?Ville $ville = null;

    #[ORM\ManyToOne(targetEntity: CodePostal::class, inversedBy: "adresses")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private ?CodePostal $codePostal = null;

    #[ORM\OneToMany(mappedBy: "adresse", targetEntity: CommercantAdresse::class, cascade: ["persist", "remove"])]
    private Collection $commercantAdresses;

    #[ORM\OneToMany(mappedBy: "adresse", targetEntity: Commerce::class, cascade: ["persist", "remove"])]
    private Collection $commerces;

    public function __construct()
    {
        $this->commercantAdresses = new ArrayCollection();
        $this->commerces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): self
    {
        $this->rue = $rue;
        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function getCodePostal(): ?CodePostal
    {
        return $this->codePostal;
    }

    public function setCodePostal(?CodePostal $codePostal): self
    {
        $this->codePostal = $codePostal;
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
            $this->commercantAdresses[] = $commercantAdresse;
            $commercantAdresse->setAdresse($this);
        }

        return $this;
    }

    public function removeCommercantAdresse(CommercantAdresse $commercantAdresse): self
    {
        if ($this->commercantAdresses->removeElement($commercantAdresse)) {
            if ($commercantAdresse->getAdresse() === $this) {
                $commercantAdresse->setAdresse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commerce>
     */
    public function getCommerces(): Collection
    {
        return $this->commerces;
    }

    public function addCommerce(Commerce $commerce): self
    {
        if (!$this->commerces->contains($commerce)) {
            $this->commerces[] = $commerce;
            $commerce->setAdresse($this);
        }

        return $this;
    }

    public function removeCommerce(Commerce $commerce): self
    {
        if ($this->commerces->removeElement($commerce)) {
            if ($commerce->getAdresse() === $this) {
                $commerce->setAdresse(null);
            }
        }

        return $this;
    }
}
