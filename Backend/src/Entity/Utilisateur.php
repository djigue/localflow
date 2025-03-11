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
#[ORM\Table(name: "utilisateur")]
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
     * @var Collection<int, Messages>
     */
    #[ORM\OneToMany(targetEntity: Messages::class, mappedBy: 'destinataire', orphanRemoval: true)]
    private Collection $messages;

    public function __construct()
    {
        $this->commerces = new ArrayCollection();
        $this->messages = new ArrayCollection();
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

    public function getAdresseId(): ?adresses
    {
        return $this->adresse;
    }

    public function setAdresseId(?adresses $adresse): static
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
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setDestinataire($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getDestinataire() === $this) {
                $message->setDestinataire(null);
            }
        }

        return $this;
    }



}
