<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $marque = null;

    #[ORM\Column(type: 'integer')]
    private ?int $prix = null; // Correction : prix est un entier

    #[ORM\Column(length: 100)]
    private ?string $finition = null;

    #[ORM\Column(length: 50)]
    private ?string $carrosserie = null;

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $mise_en_circulation = null;

    #[ORM\Column(type: 'integer')]
    private ?int $kilometres = null;

    #[ORM\Column(length: 50)]
    private ?string $energie = null;

    #[ORM\Column(length: 50)]
    private ?string $typeDeBoite = null;

    #[ORM\Column(type: 'integer')]
    private ?int $puissance = null; // Correction : puissance est un entier

    #[ORM\Column(type: 'integer')]
    private ?int $places = null; // Correction : places est un entier

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $equipement = null;

    #[ORM\Column(length: 50)]
    private ?string $image = null;

    #[ORM\Column(length: 50)]
    private ?string $image2 = null;

    #[ORM\Column(length: 50)]
    private ?string $image3 = null;

    #[ORM\Column(length: 50)]
    private ?string $image4 = null;

    #[ORM\Column(length: 50)]
    private ?string $image5 = null;

    #[ORM\Column(length: 30)]
    private ?string $classeCo2 = null;

    #[ORM\Column(length: 50)]
    private ?string $consommation = null;

    #[ORM\Column(length: 50)]
    private ?string $modele = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 50)]
    private ?string $title = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_published = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;
        return $this;
    }

    public function getPrix(): ?int // Correction : retour en int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self // Correction : type en int
    {
        $this->prix = $prix;
        return $this;
    }

    public function getFinition(): ?string
    {
        return $this->finition;
    }

    public function setFinition(string $finition): self
    {
        $this->finition = $finition;
        return $this;
    }

    public function getCarrosserie(): ?string
    {
        return $this->carrosserie;
    }

    public function setCarrosserie(string $carrosserie): self
    {
        $this->carrosserie = $carrosserie;
        return $this;
    }

    public function getMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->mise_en_circulation;
    }

    public function setMiseEnCirculation(?\DateTimeInterface $mise_en_circulation): self
    {
        $this->mise_en_circulation = $mise_en_circulation;
        return $this;
    }

    public function getKilometres(): ?int
    {
        return $this->kilometres;
    }

    public function setKilometres(?int $kilometres): self
    {
        $this->kilometres = $kilometres;
        return $this;
    }

    public function getEnergie(): ?string
    {
        return $this->energie;
    }

    public function setEnergie(string $energie): self
    {
        $this->energie = $energie;
        return $this;
    }

    public function getTypeDeBoite(): ?string
    {
        return $this->typeDeBoite;
    }

    public function setTypeDeBoite(string $typeDeBoite): self
    {
        $this->typeDeBoite = $typeDeBoite;
        return $this;
    }

    public function getPuissance(): ?int // Correction : retour en int
    {
        return $this->puissance;
    }

    public function setPuissance(int $puissance): self // Correction : type en int
    {
        $this->puissance = $puissance;
        return $this;
    }

    public function getPlaces(): ?int // Correction : retour en int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self // Correction : type en int
    {
        $this->places = $places;
        return $this;
    }

    public function getEquipement(): ?array
    {
        return $this->equipement;
    }

    public function setEquipement(?array $equipement): self
    {
        $this->equipement = $equipement;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(string $image2): self
    {
        $this->image2 = $image2;
        return $this;
    }

    public function getImage3(): ?string
    {
        return $this->image3;
    }

    public function setImage3(string $image3): self
    {
        $this->image3 = $image3;
        return $this;
    }

    public function getImage4(): ?string
    {
        return $this->image4;
    }

    public function setImage4(string $image4): self
    {
        $this->image4 = $image4;
        return $this;
    }

    public function getImage5(): ?string
    {
        return $this->image5;
    }

    public function setImage5(string $image5): self
    {
        $this->image5 = $image5;
        return $this;
    }

    public function getClasseCo2(): ?string
    {
        return $this->classeCo2;
    }

    public function setClasseCo2(?string $classeCo2): self
    {
        $this->classeCo2 = $classeCo2;
        return $this;
    }

    public function getConsommation(): ?string
    {
        return $this->consommation;
    }

    public function setConsommation(string $consommation): self
    {
        $this->consommation = $consommation;
        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getIsPublished(): ?bool
    {
        return $this->is_published;
    }

    public function setIsPublished(?bool $is_published): static
    {
        $this->is_published = $is_published;
        return $this;
    }
}
