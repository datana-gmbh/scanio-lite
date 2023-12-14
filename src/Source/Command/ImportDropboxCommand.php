<?php

declare(strict_types=1);

namespace App\Source\Command;

use App\Repository\SourceRepositoryInterface;
use App\Source\Import\DropboxImporter;
use App\Source\Value\Type;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'import:dropbox',
    description: 'Imports files from configured Sources of type dropbox',
)]
final class ImportDropboxCommand extends Command
{
    public function __construct(
        private readonly SourceRepositoryInterface $sources,
        private readonly DropboxImporter $dropboxImporter,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        $sources = $this->sources->byType(Type::Dropbox);

        foreach ($sources as $source) {
            $documents = $this->dropboxImporter->import($source);

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
