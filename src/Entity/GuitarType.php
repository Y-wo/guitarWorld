<?php

namespace App\Entity;

use App\Repository\GuitarTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuitarTypeRepository::class)]
class GuitarType extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column(length: 255)]
    private ?string $version = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $body = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pickup = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\Column(nullable: true)]
    private ?int $saddlewidth = null;

    #[ORM\Column]
    private ?bool $deleted = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $neck = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $size = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fretboard = null;

    #[ORM\Column(nullable: true)]
    private ?int $scale = null;

    #[ORM\OneToMany(mappedBy: 'GuitarType', targetEntity: Guitar::class)]
    private Collection $guitar;

    public function __construct()
    {
        $this->guitar = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(?string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getPickup(): ?string
    {
        return $this->pickup;
    }

    public function setPickup(?string $pickup): static
    {
        $this->pickup = $pickup;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSaddlewidth(): ?int
    {
        return $this->saddlewidth;
    }

    public function setSaddlewidth(?int $saddlewidth): static
    {
        $this->saddlewidth = $saddlewidth;

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

    public function getNeck(): ?string
    {
        return $this->neck;
    }

    public function setNeck(?string $neck): static
    {
        $this->neck = $neck;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getFretboard(): ?string
    {
        return $this->fretboard;
    }

    public function setFretboard(?string $fretboard): static
    {
        $this->fretboard = $fretboard;

        return $this;
    }

    public function getScale(): ?int
    {
        return $this->scale;
    }

    public function setScale(?int $scale): static
    {
        $this->scale = $scale;

        return $this;
    }

    /**
     * @return Collection<int, Guitar>
     */
    public function getGuitar(): Collection
    {
        return $this->guitar;
    }

    public function addGuitar(Guitar $guitar): static
    {
        if (!$this->guitar->contains($guitar)) {
            $this->guitar->add($guitar);
            $guitar->setGuitarType($this);
        }

        return $this;
    }

    public function removeGuitar(Guitar $guitar): static
    {
        if ($this->guitar->removeElement($guitar)) {
            // set the owning side to null (unless already changed)
            if ($guitar->getGuitarType() === $this) {
                $guitar->setGuitarType(null);
            }
        }

        return $this;
    }
}
