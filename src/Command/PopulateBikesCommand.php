<?php

namespace App\Command;

use App\Client\W3RideClient;
use App\Entity\Bike;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

#[AsCommand(
    name: 'app:populate-bikes',
    description: 'Add a short description for your command',
)]
class PopulateBikesCommand extends Command
{
    private const TOTAL = 8088;

    public function __construct(
        private W3RideClient $w3RideClient,
        private EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /* @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $question = new ConfirmationQuestion('Continue ? ', false);

        if (!$helper->ask($input, $output, $question)) {
            return Command::SUCCESS;
        }

        $this->entityManager
            ->getConnection()
            ->executeStatement('DELETE FROM bike');

        $progressBar = new ProgressBar($output, self::TOTAL);
        $progressBar->start();

        for ($i = 1; $i <= self::TOTAL; ++$i) {
            // TODO: move that in another class
            $w3RideBike = $this->w3RideClient->getBike($i);

            $bike = new Bike();
            $bike
                ->setAssetNumber($w3RideBike->getId())
                ->setScore($w3RideBike->getRarity())
                ->setPictureUrl($w3RideBike->getImageUrl());

            $this->entityManager->persist($bike);
            $this->entityManager->flush();

            sleep(1);

            $progressBar->advance();
        }

        $progressBar->finish();

        return Command::SUCCESS;
    }
}
