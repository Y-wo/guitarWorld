<?php

namespace App\Entity;

use App\Repository\AbstractEntityRepository;
use Doctrine\ORM\Mapping as ORM;

abstract class AbstractEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
