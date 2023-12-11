<?php

namespace App\Command;

use App\Client\JpgStoreClient;
use App\Entity\BikeSale;
use App\Repository\BikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:populate-sales',
    description: 'Add a short description for your command',
)]
class PopulateSalesCommand extends Command
{
    public function __construct(
        private JpgStoreClient $jpgStoreClient,
        private BikeRepository $bikeRepository,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->entityManager
            ->getConnection()
            ->executeStatement('DELETE FROM bike_sale');

        $sales = $this->jpgStoreClient->getSales();

        foreach ($sales as $sale) {
            $bike = $this->bikeRepository->findOneBy(
                ['assetNumber' => $sale->getId()],
            );
            if (null === $bike) {
                // TODO: throw exception
                continue;
            }

            $bikeSale = new BikeSale();
            $bikeSale
                ->setBike($bike)
                ->setLovelacePrice($sale->getLovelacePrice());

            $this->entityManager->persist($bikeSale);
            $this->entityManager->flush();
        }

        return Command::SUCCESS;
    }
}
