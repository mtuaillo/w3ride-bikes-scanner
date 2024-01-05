<?php

namespace App\Domain\Creator;

use App\Client\JpgStoreClient;
use App\Entity\BikeSale;
use App\Repository\BikeRepository;
use Doctrine\ORM\EntityManagerInterface;

class BikeSaleCreator
{
    public function __construct(
        private BikeRepository $bikeRepository,
        private EntityManagerInterface $entityManager,
        private JpgStoreClient $jpgStoreClient,
    ) {
    }

    /**
     * @return BikeSale[]
     *
     * @throws \Exception
     */
    public function createBikeSales(): iterable
    {
        $sales = $this->jpgStoreClient->getSales();

        foreach ($sales as $sale) {
            $bike = $this->bikeRepository->findOneBy(
                ['assetNumber' => $sale->getId()],
            );

            if (null === $bike) {
                throw new \Exception(sprintf('Bike not found: %s', $sale->getId()));
            }

            $bikeSale = new BikeSale();
            $bikeSale
                ->setBike($bike)
                ->setLovelacePrice($sale->getLovelacePrice());

            $this->entityManager->persist($bikeSale);
            $this->entityManager->flush();

            yield $bikeSale;
        }
    }
}
