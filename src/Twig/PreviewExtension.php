<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Document;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Webmozart\Assert\Assert;

final class PreviewExtension extends AbstractExtension
{
    public function __construct(
        private readonly string $projectDir,
        private readonly string $documentsDir,
    ) {
    }

    /**
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_pdf_preview', $this->renderPdfPreview(...), ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function pdfPreviewPath(Document $letter): string
    {
        $absolutePath = sprintf(
            '%s/%s',
            $this->documentsDir,
            $letter->getFilename(),
        );

        Assert::fileExists($absolutePath);

        return sprintf(
            '%s/%s',
            str_replace($this->projectDir, '', $this->documentsDir),
            $letter->getFilename(),
        );
    }

    public function renderPdfPreview(Environment $twig, Document $letter): string
    {
        return $twig->render('pdf/preview.html.twig', [
            'path' => $this->pdfPreviewPath($letter),
        ]);
    }
}
