<?php

declare(strict_types=1);

namespace App\Tests\Integration\Storage;

use App\Storage\UploadedFileWriter;
use App\Tests\Integration\IntegrationTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use function Safe\shell_exec;

final class UploadedFileWriterTest extends IntegrationTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        try {
            shell_exec('rm -rf '.self::getContainer()->getParameter('documents_dir').'/*');
        } catch (\Throwable) {
        }
    }

    /**
     * @test
     */
    public function write(): void
    {
        $writer = self::getContainer()->get(UploadedFileWriter::class);

        $file = new UploadedFile(
            path: $filepath = self::fixtureFile('blank.pdf'),
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
            path: $filepath = self::fixtureFile('blank.pdf'),
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
