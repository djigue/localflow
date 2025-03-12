<?php

namespace App\Entity;

use App\Repository\EvenementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvenementsRepository::class)]
class Evenements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_debut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_fin = null;

    #[ORM\Column]
    private ?bool $inscription = null;

    #[ORM\Column(nullable: true)]
    private ?int $nombre_participant = null;

    #[ORM\OneToOne(inversedBy: 'evenements', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?Adresses $adresse = null;

    #[ORM\Column]
    private ?int $alerte = null;

    #[ORM\ManyToOne(inversedBy: 'evenements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Commerces $commerce = null;

    #[ORM\Column]
    private ?bool $complet = null;

    /**
     * @var Collection<int, ImagesEvenements>
     */
    #[ORM\OneToMany(targetEntity: ImagesEvenements::class, mappedBy: 'evenement', orphanRemoval: true)]
    private Collection $imagesEvenements;

    public function __construct()
    {
        $this->imagesEvenements = new ArrayCollection();
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

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): static
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): static
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function isInscription(): ?bool
    {
        return $this->inscription;
    }

    public function setInscription(bool $inscription): static
    {
        $this->inscription = $inscription;

        return $this;
    }

    public function getNombreParticipant(): ?int
    {
        return $this->nombre_participant;
    }

    public function setNombreParticipant(?int $nombre_participant): static
    {
        $this->nombre_participant = $nombre_participant;

        return $this;
    }

    public function getAdresse(): ?Adresses
    {
        return $this->adresse;
    }

    public function setAdresse(Adresses $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getAlerte(): ?int
    {
        return $this->alerte;
    }

    public function setAlerte(int $alerte): static
    {
        $this->alerte = $alerte;

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

    public function isComplet(): ?bool
    {
        return $this->complet;
    }

    public function setComplet(bool $complet): static
    {
        $this->complet = $complet;

        return $this;
    }

    /**
     * @return Collection<int, ImagesEvenements>
     */
    public function getImagesEvenements(): Collection
    {
        return $this->imagesEvenements;
    }

    public function addImagesEvenement(ImagesEvenements $imagesEvenement): static
    {
        if (!$this->imagesEvenements->contains($imagesEvenement)) {
            $this->imagesEvenements->add($imagesEvenement);
            $imagesEvenement->setEvenement($this);
        }

        return $this;
    }

    public function removeImagesEvenement(ImagesEvenements $imagesEvenement): static
    {
        if ($this->imagesEvenements->removeElement($imagesEvenement)) {
            // set the owning side to null (unless already changed)
            if ($imagesEvenement->getEvenement() === $this) {
                $imagesEvenement->setEvenement(null);
            }
        }

        return $this;
    }

    public function setImage(?string $image): self
    {
        $firstImage = $this->imagesEvenements->first();

        if ($firstImage) {
            $firstImage->setUrl($image);
        }

        return $this;
    }
}
