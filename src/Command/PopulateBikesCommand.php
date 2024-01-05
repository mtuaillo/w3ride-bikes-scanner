<?php

namespace App\Command;

use App\Domain\Creator\BikeCreator;
use App\Repository\BikeRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

#[AsCommand(
    name: 'app:populate-bikes',
    description: 'Populate bikes table',
)]
class PopulateBikesCommand extends Command
{
    public function __construct(
        private BikeRepository $bikeRepository,
        private BikeCreator $bikeCreator,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');
        if (!$helper instanceof QuestionHelper) {
            return Command::FAILURE;
        }
        $question = new ConfirmationQuestion('This will empty bikes table. Continue ? ', false);

        if (!$helper->ask($input, $output, $question)) {
            return Command::SUCCESS;
        }

        $this->bikeRepository->truncateTable();

        $progressBar = new ProgressBar($output, BikeCreator::TOTAL);
        $progressBar->start();

        foreach ($this->bikeCreator->createBikes() as $bike) {
            $progressBar->advance();
        }

        $progressBar->finish();

        return Command::SUCCESS;
    }
}
