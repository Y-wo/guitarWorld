<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: ImageGuitar::class, cascade: ['persist', 'remove'])]
    private Collection $imageGuitar;

    public function __construct()
    {
        $this->imageGuitar = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, ImageGuitar>
     */
    public function getImageGuitar(): Collection
    {
        return $this->imageGuitar;
    }

    public function addImageGuitar(ImageGuitar $imageGuitar): static
    {
        if (!$this->imageGuitar->contains($imageGuitar)) {
            $this->imageGuitar->add($imageGuitar);
            $imageGuitar->setImage($this);
        }

        return $this;
    }

    public function removeImageGuitar(Guitar $imageGuitar): static
    {
        if ($this->imageGuitar->removeElement($imageGuitar)) {
            // set the owning side to null (unless already changed)
            if ($imageGuitar->getImage() === $this) {
                $imageGuitar->setImage(null);
            }
        }

        return $this;
    }
}
