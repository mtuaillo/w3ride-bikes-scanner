<?php

namespace App\Domain\Creator;

use App\Client\W3RideClient;
use App\Entity\Bike;
use Doctrine\ORM\EntityManagerInterface;

class BikeCreator
{
    public const TOTAL = 8088;

    public function __construct(
        private W3RideClient $w3RideClient,
        private EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * @return Bike[]
     */
    public function createBikes(): iterable
    {
        for ($i = 1; $i <= self::TOTAL; ++$i) {
            $w3RideBike = $this->w3RideClient->getBike($i);

            $bike = new Bike();
            $bike
                ->setAssetNumber($w3RideBike->getId())
                ->setScore($w3RideBike->getRarity())
                ->setPictureUrl($w3RideBike->getImageUrl());

            $this->entityManager->persist($bike);
            $this->entityManager->flush();

            yield $bike;
        }
    }
}
