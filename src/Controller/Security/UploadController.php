<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Entity\Document;
use App\Form\UploadFormType;
use App\Repository\DocumentRepositoryInterface;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Ulid;

#[Route(name: Routes::UPLOAD, path: '/upload')]
final readonly class UploadController
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private Responder $responder,
        private LoggerInterface $logger,
        private DocumentRepositoryInterface $documentRepository,
        private string $documentsDir,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $flashBag = $request->getSession()->getFlashBag();

        $form = $this->formFactory->create(UploadFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $file */
            $file = $form->get('file')->getData();
            /** @var Group $group */
            $group = $form->get('group')->getData();
            /** @var \DateTime $inboxDate */
            $inboxDate = $form->get('inboxDate')->getData();
            $filename = sprintf('%s.%s', (new Ulid())->toBase32(), $file->guessExtension());

            $document = new Document($filename);

            try {
                $file->move($this->documentsDir, $filename);

                $document->setCategory(Category::Pending);
                $document->setGroup($group);
                $document->setInboxDate(\DateTimeImmutable::createFromMutable($inboxDate));

                $this->documentRepository->save($document);

                $flashBag->add('success', 'Die Datei wurde hochgeladen und zur Weiterverarbeitung vorgemerkt.');

                return $this->responder->route(Routes::DASHBOARD);
            } catch (\Throwable $e) {
                $flashBag->add('error', 'Die Datei konnte nicht hochgeladen werden.');

                $this->logger->error(sprintf('Upload failed with message: %s', $e->getMessage()), [
                    'filename' => $document->getFilename(),
                    'documentId' => $document->getId()->toString(),
                ]);
            }
        }

        return $this->responder->render('upload/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
