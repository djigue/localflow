<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    
    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;
    
    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    private ?string $prix = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageUrl = null;
    
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $createdAt = null;
    
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }
    
    // ------------------- GETTERS & SETTERS ------------------- //
    
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
    
    // Mise à jour : getter et setter pour 'prix' en tant que string
    public function getPrix(): ?string
    {
        return $this->prix;
    }
    
    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;
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
    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }
    
    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
