<?php

declare(strict_types=1);

namespace App\Command;

use App\Bridge\Dropbox\Domain\Value\FilesystemElement;
use App\Creator\DocumentCreatorInterface;
use App\Domain\Enum\StorageType;
use App\Repository\StorageRepositoryInterface;
use Psr\Log\LoggerInterface;
use Spatie\Dropbox\Client;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'import:dropbox',
    description: 'Imports files from configured Storages of type dropbox.',
)]
final class ImportDropboxCommand extends Command
{
    public function __construct(
        private readonly StorageRepositoryInterface $storages,
        private readonly DocumentCreatorInterface $creator,
        private readonly LoggerInterface $logger,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('delete-after-import', null, InputOption::VALUE_NONE, 'Deletes files after importing from configured dropbox');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title($this->getDescription());

        $storages = $this->storages->byType(StorageType::Dropbox);

        $deleteAfterImport = false;

        if ($input->getOption('delete-after-import')) {
            $deleteAfterImport = true;
        }

        $io->text(sprintf('Found %s storages with dropbox', \count($storages)));

        foreach ($storages as $storage) {
            if (!$storage->isEnabled()) {
                $io->warning(
                    sprintf(
                        'Storage %s: %s is not enabled.',
                        $storage->getStorageType()->label(),
                        $storage->getPath(),
                    ),
                );

                continue;
            }

            $client = new Client($storage->getToken());
            /** @var string $path */
            $path = $storage->getPath();

            // removes all values which are no array. Somehow it can happen that there are strings.
            $response = array_filter(
                $client->listFolder($path, $storage->isRecursive()),
                static fn (array|string $item): bool => \is_array($item),
            );

            foreach ($response as $files) {
                $io->text(sprintf('Found <info>%s</info> files in <info>%s</info>', \count($files), $path));

                foreach ($files as $file) {
                    try {
                        $element = FilesystemElement::fromResponse($file);
                    } catch (\InvalidArgumentException) {
                        $this->logger->error('Invalid Dropbox response', [
                            'response' => $file,
                        ]);

                        continue;
                    }

                    if (!$element->isDir && !$element->isDownloadable) {
                        $io->warning(sprintf('File %s is not downloadable', $element->name));

                        continue;
                    }

                    if ($element->isDir) {
                        // @TODO: Do some recursion here

                        continue;
                    }

                    try {
                        $document = $this->creator->fromResource(
                            $element->name,
                            $client->download($element->path),
                        );

                        $io->text(sprintf(
                            'Created Document with ID <info>%s</info> from <info>%s</info>',
                            $document->getId()->toString(),
                            $document->getOriginalFilename(),
                        ));

                        if ($deleteAfterImport) {
                            $client->delete($element->path);
                            $io->text(sprintf('Deleted remote file <info>%s</info>', $element->path));
                        }
                    } catch (\Throwable $e) {
                        $this->logger->error($e->getMessage());
                    }
                }
            }
        }

        $io->success('Done');

        return Command::SUCCESS;
    }
}
