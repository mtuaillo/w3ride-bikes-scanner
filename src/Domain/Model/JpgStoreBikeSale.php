<?php

namespace App\Domain\Model;

final class JpgStoreBikeSale
{
    public function __construct(
        private string $id,
        private string $cardanoTokenAddress,
        private int $lovelacePrice,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCardanoTokenAddress(): string
    {
        return $this->cardanoTokenAddress;
    }

    public function setCardanoTokenAddress(string $cardanoTokenAddress): JpgStoreBikeSale
    {
        $this->cardanoTokenAddress = $cardanoTokenAddress;

        return $this;
    }

    public function getLovelacePrice(): int
    {
        return $this->lovelacePrice;
    }

    public function setLovelacePrice(int $lovelacePrice): JpgStoreBikeSale
    {
        $this->lovelacePrice = $lovelacePrice;

        return $this;
    }
}
