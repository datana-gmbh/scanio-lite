<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use OskarStark\Enum\Trait\Comparable;

enum Extension: string
{
    use Comparable;

    case TIF = 'tif';
    case TIFF = 'tiff';
    case PDF = 'pdf';
    case ZIP = 'zip';
    case JPG = 'jpg';
    case PNG = 'png';
    case JP2 = 'jp2';

    public static function fromMimeType(string $mimeType): self
    {
        return match ($mimeType) {
            'application/pdf' => self::PDF,
            'application/zip' => self::ZIP,
            'image/jpeg' => self::JPG,
            'image/png' => self::PNG,
            'image/jp2' => self::JP2,
            'image/tiff' => self::TIFF,
            default => throw new \InvalidArgumentException(sprintf('Mimetype "%s" is not supported.', $mimeType)),
        };
    }
}
