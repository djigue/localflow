<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface; 
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
// #[ORM\Table(name: "utilisateur")]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $civilite = null;

    #[ORM\Column(length: 50)]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    private ?string $prenom = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $pseudo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 100)]
    private ?string $password = null;

    #[ORM\Column(length: 20)]
    private ?string $email = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\ManyToOne(inversedBy: 'utilisateur')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Adresses $adresse = null;

    #[ORM\Column(length: 20)]
    private ?string $role = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_inscription = null;

    #[ORM\Column]
    private ?bool $ambassadeur = null;

    #[ORM\Column]
    private ?int $experience = null;

    /**
     * @var Collection<int, Commerces>
     */
    #[ORM\OneToMany(targetEntity: Commerces::class, mappedBy: 'commercant', orphanRemoval: true)]
    private Collection $commerces;

    /**
     * @var Collection<int, Panier>
     */
    #[ORM\OneToMany(targetEntity: Panier::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $paniers;

    /**
     * @var Collection<int, PaniersProduits>
     */
    #[ORM\OneToMany(targetEntity: PaniersProduits::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $paniersProduits;

    /**
     * @var Collection<int, PaniersServices>
     */
    #[ORM\OneToMany(targetEntity: PaniersServices::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $paniersServices;

    /**
     * @var Collection<int, PaniersProduits>
     */
    #[ORM\OneToMany(targetEntity: PaniersProduits::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $panierProduit;

    /**
     * @var Collection<int, PaniersPromotions>
     */
    #[ORM\OneToMany(targetEntity: PaniersPromotions::class, mappedBy: 'utilisateur', orphanRemoval: true)]
    private Collection $paniersPromotions;

    public function __construct()
    {
        $this->commerces = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->paniersProduits = new ArrayCollection();
        $this->paniersServices = new ArrayCollection();
        $this->panierProduit = new ArrayCollection();
        $this->paniersPromotions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCivilite(): ?string
    {
        return $this->civilite;
    }

    public function setCivilite(?string $civilite): static
    {
        $this->civilite = $civilite;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $date_naissance): static
    {
        $this->date_naissance = $date_naissance;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAdresseId(): ?Adresses
    {
        return $this->adresse;
    }

    public function setAdresseId(?Adresses $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = [];
    
        if ($this->role === 'client') {
            $roles[] = 'ROLE_CLIENT';
        } elseif ($this->role === 'commercant') {
            $roles[] = 'ROLE_COMMERCANT';
        }
    
    
        $roles[] = 'ROLE_USER'; // Ajout obligatoire pour Symfony
    
        return array_unique($roles);
    }

    public function getRole(): string
    {
        return $this->role;
    }
    

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): static
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    public function isAmbassadeur(): ?bool
    {
        return $this->ambassadeur;
    }

    public function setAmbassadeur(bool $ambassadeur): static
    {
        $this->ambassadeur = $ambassadeur;

        return $this;
    }

    public function getExperience(): ?int
    {
        return $this->experience;
    }

    public function setExperience(int $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getUserIdentifier() : string
    {
        return (string) $this->id;
    }

    public function eraseCredentials(): void
{
    // Optionnel : Si tu as des informations sensibles à effacer, fais-le ici
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
            $commerce->setCommercant($this);
        }

        return $this;
    }

    public function removeCommerce(Commerces $commerce): static
    {
        if ($this->commerces->removeElement($commerce)) {
            // set the owning side to null (unless already changed)
            if ($commerce->getCommercant() === $this) {
                $commerce->setCommercant(null);
            }
        }

        return $this;
    }

    public function getCommerceIds(): array
    {
       return $this->commerces->map(fn($commerce) => $commerce->getId())->toArray();
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
            $panier->setUtilisateur($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): static
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getUtilisateur() === $this) {
                $panier->setUtilisateur(null);
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
            $paniersProduit->setUtilisateur($this);
        }

        return $this;
    }

    public function removePaniersProduit(PaniersProduits $paniersProduit): static
    {
        if ($this->paniersProduits->removeElement($paniersProduit)) {
            // set the owning side to null (unless already changed)
            if ($paniersProduit->getUtilisateur() === $this) {
                $paniersProduit->setUtilisateur(null);
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
            $paniersService->setUtilisateur($this);
        }

        return $this;
    }

    public function removePaniersService(PaniersServices $paniersService): static
    {
        if ($this->paniersServices->removeElement($paniersService)) {
            // set the owning side to null (unless already changed)
            if ($paniersService->getUtilisateur() === $this) {
                $paniersService->setUtilisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PaniersProduits>
     */
    public function getPanierProduit(): Collection
    {
        return $this->panierProduit;
    }

    public function addPanierProduit(PaniersProduits $panierProduit): static
    {
        if (!$this->panierProduit->contains($panierProduit)) {
            $this->panierProduit->add($panierProduit);
            $panierProduit->setUtilisateur($this);
        }

        return $this;
    }

    public function removePanierProduit(PaniersProduits $panierProduit): static
    {
        if ($this->panierProduit->removeElement($panierProduit)) {
            // set the owning side to null (unless already changed)
            if ($panierProduit->getUtilisateur() === $this) {
                $panierProduit->setUtilisateur(null);
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
            $paniersPromotion->setUtilisateur($this);
        }

        return $this;
    }

    public function removePaniersPromotion(PaniersPromotions $paniersPromotion): static
    {
        if ($this->paniersPromotions->removeElement($paniersPromotion)) {
            // set the owning side to null (unless already changed)
            if ($paniersPromotion->getUtilisateur() === $this) {
                $paniersPromotion->setUtilisateur(null);
            }
        }

        return $this;
    }



}
