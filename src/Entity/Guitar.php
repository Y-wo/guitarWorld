<?php

namespace App\Entity;

use App\Repository\GuitarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuitarRepository::class)]
class Guitar extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id ;

    #[ORM\ManyToOne(inversedBy: 'model')]
    #[ORM\JoinColumn(nullable: true)]
    private ?GuitarType $GuitarType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $model = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column]
    private ?bool $deleted = null;

    #[ORM\Column(length: 255)]
    private ?int $price = null;

    #[ORM\Column(nullable: true)]
    private ?bool $used = null;

    #[ORM\ManyToOne(inversedBy: 'guitar')]
    private ?Order $guitarOrder = null;

    #[ORM\OneToMany(mappedBy: 'guitar', targetEntity: ImageGuitar::class, cascade: ['persist', 'remove'])]
    private Collection $imageGuitar;

    public function __construct()
    {
        $this->imageGuitar = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, ImageGuitar>
     */
    public function getImageGuitar(): Collection
    {
        return $this->imageGuitar;
    }

    public function addGuitar(ImageGuitar $imageGuitar): static
    {
        if (!$this->imageGuitar->contains($imageGuitar)) {
            $this->imageGuitar->add($imageGuitar);
            $imageGuitar->setGuitar($this);
        }

        return $this;
    }

    public function removeImageGuitar(Guitar $imageGuitar): static
    {
        if ($this->imageGuitar->removeElement($imageGuitar)) {
            // set the owning side to null (unless already changed)
            if ($imageGuitar->getGuitar() === $this) {
                $imageGuitar->setGuitar(null);
            }
        }

        return $this;
    }
}
