<?php

namespace App\Domain\Model;

class W3RideBike
{
    public function __construct(
        private string $id,
        private float $rarity,
        private string $imageUrl
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getRarity(): float
    {
        return $this->rarity;
    }

    public function getImageUrl(): string
    {
        return $this->imageUrl;
    }
}
