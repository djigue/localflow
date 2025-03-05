<?php

namespace App\Entity;

use App\Repository\CommercesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommercesRepository::class)]
class Commerces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(type: 'string', length:14)]
    private ?int $siret = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 20)]
    private ?string $secteur_activite = null;

    #[ORM\Column]
    private ?bool $fixe = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $livraison = null;

    #[ORM\Column]
    private ?bool $eco_responsable = null;

    #[ORM\Column(length: 20)]
    private ?string $statut = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lien = null;

    #[ORM\ManyToOne(inversedBy: 'commerces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $commercant = null;

    /**
     * @var Collection<int, Adresses>
     */
    #[ORM\ManyToMany(targetEntity: Adresses::class, inversedBy: 'commerces')]
    private Collection $adresses;

    /**
     * @var Collection<int, Horaires>
     */
    #[ORM\OneToMany(targetEntity: Horaires::class, mappedBy: 'commerce', orphanRemoval: true)]
    private Collection $horaires;

    /**
     * @var Collection<int, ImagesCommerces>
     */
    #[ORM\OneToMany(targetEntity: ImagesCommerces::class, mappedBy: 'commerce', orphanRemoval: true)]
    private Collection $imagesCommerces;

    /**
     * @var Collection<int, Evenements>
     */
    #[ORM\OneToMany(targetEntity: Evenements::class, mappedBy: 'commerce', orphanRemoval: true)]
    private Collection $evenements;

    /**
     * @var Collection<int, Produits>
     */
    #[ORM\OneToMany(targetEntity: Produits::class, mappedBy: 'commerce', orphanRemoval: true)]
    private Collection $produits;

    /**
     * @var Collection<int, Services>
     */
    #[ORM\OneToMany(targetEntity: Services::class, mappedBy: 'commerce', orphanRemoval: true)]
    private Collection $services;

    /**
     * @var Collection<int, ImagesProduits>
     */

    public function __construct()
    {
        $this->adresses = new ArrayCollection();
        $this->horaires = new ArrayCollection();
        $this->imagesCommerces = new ArrayCollection();
        $this->evenements = new ArrayCollection();
        $this->produits = new ArrayCollection();
        $this->services = new ArrayCollection();
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

    public function getSiret(): ?int
    {
        return $this->siret;
    }

    public function setSiret(int $siret): static
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
        return $this->secteur_activite;
    }

    public function setSecteurActivite(string $secteur_activite): static
    {
        $this->secteur_activite = $secteur_activite;

        return $this;
    }

    public function isFixe(): ?bool
    {
        return $this->fixe;
    }

    public function setFixe(bool $fixe): static
    {
        $this->fixe = $fixe;

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

    public function isLivraison(): ?bool
    {
        return $this->livraison;
    }

    public function setLivraison(bool $livraison): static
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function isEcoResponsable(): ?bool
    {
        return $this->eco_responsable;
    }

    public function setEcoResponsable(bool $eco_responsable): static
    {
        $this->eco_responsable = $eco_responsable;

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

    public function getLien(): ?string
    {
        return $this->lien;
    }

    public function setLien(?string $lien): static
    {
        $this->lien = $lien;

        return $this;
    }

    public function getCommercant(): ?Utilisateur
    {
        return $this->commercant;
    }

    public function setCommercant(?Utilisateur $commercant): static
    {
        $this->commercant = $commercant;

        return $this;
    }

    /**
     * @return Collection<int, Adresses>
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresses $adress): static
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses->add($adress);
        }

        return $this;
    }

    public function removeAdress(Adresses $adress): static
    {
        $this->adresses->removeElement($adress);

        return $this;
    }

    /**
     * @return Collection<int, Horaires>
     */
    public function getHoraires(): Collection
    {
        return $this->horaires;
    }

    public function addHoraire(Horaires $horaire): static
    {
        if (!$this->horaires->contains($horaire)) {
            $this->horaires->add($horaire);
            $horaire->setCommerce($this);
        }

        return $this;
    }

    public function removeHoraire(Horaires $horaire): static
    {
        if ($this->horaires->removeElement($horaire)) {
            // set the owning side to null (unless already changed)
            if ($horaire->getCommerce() === $this) {
                $horaire->setCommerce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ImagesCommerces>
     */
    public function getImagesCommerces(): Collection
    {
        return $this->imagesCommerces;
    }

    public function addImagesCommerce(ImagesCommerces $imagesCommerce): static
    {
        if (!$this->imagesCommerces->contains($imagesCommerce)) {
            $this->imagesCommerces->add($imagesCommerce);
            $imagesCommerce->setCommerce($this);
        }

        return $this;
    }

    public function removeImagesCommerce(ImagesCommerces $imagesCommerce): static
    {
        if ($this->imagesCommerces->removeElement($imagesCommerce)) {
            // set the owning side to null (unless already changed)
            if ($imagesCommerce->getCommerce() === $this) {
                $imagesCommerce->setCommerce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evenements>
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenements $evenement): static
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements->add($evenement);
            $evenement->setCommerce($this);
        }

        return $this;
    }

    public function removeEvenement(Evenements $evenement): static
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getCommerce() === $this) {
                $evenement->setCommerce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produits $produit): static
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setCommerce($this);
        }

        return $this;
    }

    public function removeProduit(Produits $produit): static
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCommerce() === $this) {
                $produit->setCommerce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Services>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Services $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setCommerce($this);
        }

        return $this;
    }

    public function removeService(Services $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCommerce() === $this) {
                $service->setCommerce(null);
            }
        }

        return $this;
    }

}
