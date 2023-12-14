<?php

declare(strict_types=1);

namespace App\Command;

use App\Domain\Enum\StorageType;
use App\Import\DropboxImporter;
use App\Repository\StorageRepositoryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'import:dropbox',
    description: 'Imports files from configured Storages of type dropbox',
)]
final class ImportDropboxCommand extends Command
{
    public function __construct(
        private readonly StorageRepositoryInterface $storages,
        private readonly DropboxImporter $dropboxImporter,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        $storages = $this->storages->byType(StorageType::Dropbox);

        foreach ($storages as $storage) {
            $documents = $this->dropboxImporter->import($storage);

            $io->text(sprintf(
                'Imported <info>%s</> documents from <info>%s</>',
                \count($documents),
                (string) $storage,
            ));
        }

        $io->success('Done');

        return Command::SUCCESS;
    }
}
