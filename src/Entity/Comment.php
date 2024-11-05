<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $overall = null;

    #[ORM\Column]
    private ?int $housing = null;

    #[ORM\Column(length: 255)]
    private ?string $housingCom = null;

    #[ORM\Column]
    private ?int $food = null;

    #[ORM\Column(length: 255)]
    private ?string $foodCom = null;

    #[ORM\Column]
    private ?int $transport = null;

    #[ORM\Column(length: 255)]
    private ?string $transportCom = null;

    #[ORM\Column]
    private ?int $security = null;

    #[ORM\Column(length: 255)]
    private ?string $securityCom = null;

    #[ORM\Column]
    private ?int $administration = null;

    #[ORM\Column(length: 255)]
    private ?string $administrationCom = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOverall(): ?string
    {
        return $this->overall;
    }

    public function setOverall(string $overall): static
    {
        $this->overall = $overall;

        return $this;
    }

    public function getHousing(): ?int
    {
        return $this->housing;
    }

    public function setHousing(int $housing): static
    {
        $this->housing = $housing;

        return $this;
    }

    public function getHousingCom(): ?string
    {
        return $this->housingCom;
    }

    public function setHousingCom(string $housingCom): static
    {
        $this->housingCom = $housingCom;

        return $this;
    }

    public function getFood(): ?int
    {
        return $this->food;
    }

    public function setFood(int $food): static
    {
        $this->food = $food;

        return $this;
    }

    public function getFoodCom(): ?string
    {
        return $this->foodCom;
    }

    public function setFoodCom(string $foodCom): static
    {
        $this->foodCom = $foodCom;

        return $this;
    }

    public function getTransport(): ?int
    {
        return $this->transport;
    }

    public function setTransport(int $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    public function getTransportCom(): ?string
    {
        return $this->transportCom;
    }

    public function setTransportCom(string $transportCom): static
    {
        $this->transportCom = $transportCom;

        return $this;
    }

    public function getSecurity(): ?int
    {
        return $this->security;
    }

    public function setSecurity(int $security): static
    {
        $this->security = $security;

        return $this;
    }

    public function getSecurityCom(): ?string
    {
        return $this->securityCom;
    }

    public function setSecurityCom(string $securityCom): static
    {
        $this->securityCom = $securityCom;

        return $this;
    }

    public function getAdministration(): ?int
    {
        return $this->administration;
    }

    public function setAdministration(int $administration): static
    {
        $this->administration = $administration;

        return $this;
    }

    public function getAdministrationCom(): ?string
    {
        return $this->administrationCom;
    }

    public function setAdministrationCom(string $administrationCom): static
    {
        $this->administrationCom = $administrationCom;

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
}
