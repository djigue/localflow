<?php

namespace App\Entity;

use App\Repository\AdressesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdressesRepository::class)]
class Adresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $numero = null;

    #[ORM\Column(length: 255)]
    private ?string $rue = null;

    #[ORM\ManyToOne(inversedBy: 'adresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Villes $ville = null;

    /**
     * @var Collection<int, Commerces>
     */
    #[ORM\ManyToMany(targetEntity: Commerces::class, mappedBy: 'adresses')]
    private Collection $commerces;

    #[ORM\OneToOne(mappedBy: 'adresse', cascade: ['persist', 'remove'])]
    private ?Evenements $evenements = null;

    public function __construct()
    {
        $this->commerces = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(?int $numero): static
    {
        $this->numero = $numero;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getVillesId(): ?villes
    {
        return $this->ville;
    }

    public function setVillesId(Villes $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection<int, Commerces>
     */
    public function getCommerces(): Collection
    {
        return $this->commerces;
    }

    public function addCommerce(Commerces $commerce): static
    {
        if (!$this->commerces->contains($commerce)) {
            $this->commerces->add($commerce);
            $commerce->addAdress($this);
        }

        return $this;
    }

    public function removeCommerce(Commerces $commerce): static
    {
        if ($this->commerces->removeElement($commerce)) {
            $commerce->removeAdress($this);
        }

        return $this;
    }

    public function getEvenements(): ?Evenements
    {
        return $this->evenements;
    }

    public function setEvenements(Evenements $evenements): static
    {
        // set the owning side of the relation if necessary
        if ($evenements->getAdresse() !== $this) {
            $evenements->setAdresse($this);
        }

        $this->evenements = $evenements;

        return $this;
    }

}
