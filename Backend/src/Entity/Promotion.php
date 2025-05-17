<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]
    private ?string $nom = null;
    
    #[ORM\Column(type: "text", nullable: true)]
    private ?string $description = null;
    
    #[ORM\Column(type: "decimal", precision: 5, scale: 2)]
    private ?string $reduction = null;
    
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $dateDebut = null;
    
    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $dateFin = null;
    
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
    
    // Correction : travailler avec string pour le champ decimal reduction
    public function getReduction(): ?string
    {
        return $this->reduction;
    }
    
    public function setReduction(string $reduction): static
    {
        $this->reduction = $reduction;
        return $this;
    }
    
    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }
    
    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }
    
    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }
    
    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;
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
