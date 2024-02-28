<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order extends AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $payDate = null;

    #[ORM\OneToOne(mappedBy: 'guitarOrder')]
    private ?Guitar $guitar = null;

    #[ORM\ManyToOne(inversedBy: 'orders', fetch: "EAGER")]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $paid = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $canceled = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPayDate(): ?\DateTimeInterface
    {
        return $this->payDate;
    }

    public function setPayDate(\DateTimeInterface $payDate): static
    {
        $this->payDate = $payDate;

        return $this;
    }

    public function getGuitar(): ?Guitar
    {
        return $this->guitar;
    }

    public function setGuitar(?Guitar $guitar): static
    {
        // unset the owning side of the relation if necessary
        if ($guitar === null && $this->guitar !== null) {
            $this->guitar->setGuitarOrder(null);
        }

        // set the owning side of the relation if necessary
        if ($guitar !== null && $guitar->getGuitarOrder() !== $this) {
            $guitar->setGuitarOrder($this);
        }

        $this->guitar = $guitar;

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

    public function getPaid(): ?\DateTimeInterface
    {
        return $this->paid;
    }

    public function setPaid(?\DateTimeInterface $paid): static
    {
        $this->paid = $paid;

        return $this;
    }

    public function getCanceled(): ?\DateTimeInterface
    {
        return $this->canceled;
    }

    public function setCanceled(?\DateTimeInterface $canceled): static
    {
        $this->canceled = $canceled;

        return $this;
    }
}
