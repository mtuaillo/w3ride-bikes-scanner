<?php

namespace App\Domain\Model;

final class Bike
{
    private ?float $rarity;

    public function __construct(
        private string $id,
        private int $lovelacePrice,
    ) {
    }

    public function getId()
    {
        return$this->id;
    }

    public function getRarity(): ?float
    {
        return $this->rarity;
    }

    public function setRarity(?float $rarity): Bike
    {
        $this->rarity = $rarity;

        return $this;
    }
}
