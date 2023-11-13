<?php

namespace App\Command;

use App\Client\JpgStoreClient;
use App\Client\W3RideClient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
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
        private W3RideClient $w3RideClient,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $sales = $this->jpgStoreClient->getSales();

        foreach ($sales as $sale) {
            // TODO
        }

        return Command::SUCCESS;
    }
}
