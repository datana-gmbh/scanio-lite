<?php

declare(strict_types=1);

namespace App\Tests\Integration\Storage;

use App\Storage\UploadedFileWriter;
use App\Tests\Integration\IntegrationTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class UploadedFileWriterTest extends IntegrationTestCase
{
    /**
     * @test
     */
    public function write(): void
    {
        $writer = self::getContainer()->get(UploadedFileWriter::class);

        $file = new UploadedFile(
            path: $filepath = __DIR__.'/../../Fixtures/blank.pdf',
            originalName: $filename = basename($filepath),
        );

        $writer->write($file);

        self::assertFileExistsOnStorage($filename);
    }

    /**
     * @test
     */
    public function writeSameFileTwiceShouldThrowAnException(): void
    {
        $writer = self::getContainer()->get(UploadedFileWriter::class);

        $file = new UploadedFile(
            path: $filepath = __DIR__.'/../../Fixtures/blank.pdf',
            originalName: $filename = basename($filepath),
        );

        $writer->write($file);

        self::assertFileExistsOnStorage($filename);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('File already exists');

        $writer->write($file);
    }

    private static function assertFileExistsOnStorage(string $filename): void
    {
        self::assertFileExists(sprintf(
            '%s/%s',
            self::getContainer()->getParameter('documents_dir'),
            $filename,
        ));
    }
}
