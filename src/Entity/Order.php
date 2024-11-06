<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $enfants = null;

    #[ORM\Column]
    private ?int $animal = null;

    #[ORM\Column]
    private ?bool $vaccins = null;

    #[ORM\Column]
    private ?bool $voiture = null;

    #[ORM\Column]
    private ?bool $passeport = null;

    #[ORM\Column]
    private ?int $term = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastname(string $nom): static
    {
        $this->lastName = $nom;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getEnfants(): ?int
    {
        return $this->enfants;
    }

    public function setEnfants(int $enfants): static
    {
        $this->enfants = $enfants;

        return $this;
    }

    public function getAnimal(): ?int
    {
        return $this->animal;
    }

    public function setAnimal(int $animal): static
    {
        $this->animal = $animal;

        return $this;
    }

    public function isVaccins(): ?bool
    {
        return $this->vaccins;
    }

    public function setVaccins(bool $vaccins): static
    {
        $this->vaccins = $vaccins;

        return $this;
    }

    public function isVoiture(): ?bool
    {
        return $this->voiture;
    }

    public function setVoiture(bool $voiture): static
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function isPasseport(): ?bool
    {
        return $this->passeport;
    }

    public function setPasseport(bool $passeport): static
    {
        $this->passeport = $passeport;

        return $this;
    }

    public function getTerm(): ?int
    {
        return $this->term;
    }

    public function setTerm(int $term): static
    {
        $this->term = $term;

        return $this;
    }
}
