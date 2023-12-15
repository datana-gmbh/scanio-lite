<?php

declare(strict_types=1);

namespace App\Source\Command;

use App\Repository\SourceRepositoryInterface;
use App\Source\Importer\ImporterFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'import:sources',
    description: 'Import files from configured Sources',
)]
final class ImportSourcesCommand extends Command
{
    public function __construct(
        private readonly SourceRepositoryInterface $sources,
        private readonly ImporterFactory $importerFactory,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        foreach ($this->sources->findEnabled() as $source) {
            try {
                $importer = $this->importerFactory->forSource($source);
            } catch (\InvalidArgumentException $e) {
                $io->text(sprintf('Skipping Source <info>%s</>: %s', $source, $e->getMessage()));

                continue;
            }

            $documents = $importer->import($source);

            $io->text(sprintf(
                'Imported <info>%s</> documents from <info>%s</>',
                \count($documents),
                $source,
            ));
        }

        $io->success('Done');

        return Command::SUCCESS;
    }
}
