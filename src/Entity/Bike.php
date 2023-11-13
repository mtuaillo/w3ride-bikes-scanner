<?php

namespace App\Entity;

use App\Repository\BikeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: BikeRepository::class)]
#[UniqueEntity('assetNumber')]
class Bike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $assetNumber = null;

    #[ORM\Column]
    private ?float $score = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $pictureUrl = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssetNumber(): ?string
    {
        return $this->assetNumber;
    }

    public function setAssetNumber(?string $assetNumber): Bike
    {
        $this->assetNumber = $assetNumber;

        return $this;
    }

    public function getScore(): ?float
    {
        return $this->score;
    }

    public function setScore(?float $score): Bike
    {
        $this->score = $score;

        return $this;
    }

    public function getPictureUrl(): ?string
    {
        return $this->pictureUrl;
    }

    public function setPictureUrl(?string $pictureUrl): Bike
    {
        $this->pictureUrl = $pictureUrl;

        return $this;
    }
}
