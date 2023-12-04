<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\CreateIncomingDocumentFormType;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: Routes::UPLOAD_FILE, path: '/upload/file')]
final readonly class UploadFileController
{
    public function __construct(
        private Responder $responder,
        private FormFactoryInterface $formFactory,
    ) {
    }

    public function __invoke(Request $request, RequestStack $requestStack): Response
    {
        $form = $this->formFactory->create(CreateIncomingDocumentFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // @TODO Implement the file handling here.
            $requestStack->getSession()->getFlashBag()->add('success', 'Die Datei wurde hochgeladen und zur Weiterverarbeitung vorgemerkt.');

            return $this->responder->route(Routes::DASHBOARD);
        }

        return $this->responder->render('upload/upload_file.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
