<?php

namespace App\Entity;

use App\Repository\GuitarRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuitarRepository::class)]
class Guitar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'model')]
    #[ORM\JoinColumn(nullable: false)]
    private ?GuitarType $GuitarType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column]
    private ?bool $deleted = null;

    #[ORM\Column(length: 255)]
    private ?string $price = null;

    #[ORM\Column(nullable: true)]
    private ?bool $used = null;

    #[ORM\ManyToOne(inversedBy: 'guitar', cascade: ['persist', 'remove'])]
    private ?Order $guitarOrder = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGuitarType(): ?GuitarType
    {
        return $this->GuitarType;
    }

    public function setGuitarType(?GuitarType $GuitarType): static
    {
        $this->GuitarType = $GuitarType;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }


    public function isDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): static
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function isUsed(): ?bool
    {
        return $this->used;
    }

    public function setUsed(?bool $used): static
    {
        $this->used = $used;

        return $this;
    }

    public function getGuitarOrder(): ?Order
    {
        return $this->guitarOrder;
    }

    public function setGuitarOrder(?Order $guitarOrder): static
    {
        $this->guitarOrder = $guitarOrder;

        return $this;
    }
}
