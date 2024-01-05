<?php

namespace App\Command;

use App\Domain\Creator\BikeSaleCreator;
use App\Repository\BikeSaleRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:populate-sales',
    description: 'Populate bike sales table',
)]
class PopulateSalesCommand extends Command
{
    public function __construct(
        private BikeSaleRepository $bikeSaleRepository,
        private BikeSaleCreator $bikeSaleCreator,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->bikeSaleRepository->truncateTable();

        $progressBar = new ProgressBar($output);
        $progressBar->start();

        foreach ($this->bikeSaleCreator->createBikeSales() as $bikeSale) {
            $progressBar->advance();
        }

        $progressBar->finish();

        return Command::SUCCESS;
    }
}
