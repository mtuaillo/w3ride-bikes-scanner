<?php

namespace App\Entity;

use App\Repository\BikeSaleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BikeSaleRepository::class)]
class BikeSale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $lovelacePrice = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Bike $bike = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLovelacePrice(): ?int
    {
        return $this->lovelacePrice;
    }

    public function setLovelacePrice(int $lovelacePrice): static
    {
        $this->lovelacePrice = $lovelacePrice;

        return $this;
    }

    public function getBike(): ?Bike
    {
        return $this->bike;
    }

    public function setBike(?Bike $bike): static
    {
        $this->bike = $bike;

        return $this;
    }
}
