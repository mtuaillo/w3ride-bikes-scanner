<?php

namespace App\Command;

use App\Repository\BikeSaleRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:list-sales',
    description: 'List best deals by score',
)]
class ListSalesCommand extends Command
{
    public function __construct(
        private BikeSaleRepository $bikeSaleRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $bestDeals = $this->bikeSaleRepository->getBestDealsByScore();

        $table = new Table($output);
        $table
            ->setHeaders(['Score', 'Bike #', 'Price'])
            ->setRows($bestDeals)
        ;
        $table->render();

        return Command::SUCCESS;
    }
}
