<?php

declare(strict_types=1);

namespace App\Twig;

use App\Entity\Document;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Webmozart\Assert\Assert;

final class PreviewExtension extends AbstractExtension
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
        #[Autowire('%documents_dir%')]
        private readonly string $documentsDir,
    ) {
    }

    /**
     * @return list<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('render_pdf_preview', $this->renderPdfPreview(...), ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function pdfPreviewPath(Document $document): string
    {
        $absolutePath = sprintf(
            '%s/%s',
            $this->documentsDir,
            $document->getFilename(),
        );

        Assert::fileExists($absolutePath);

        return sprintf(
            '%s/%s',
            str_replace(sprintf('%s/public', $this->projectDir), '', $this->documentsDir),
            $document->getFilename(),
        );
    }

    public function renderPdfPreview(Environment $twig, Document $document): string
    {
        return $twig->render('secured/pdf/preview.html.twig', [
            'path' => $this->pdfPreviewPath($document),
        ]);
    }
}
