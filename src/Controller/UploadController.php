<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\UploadFormType;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: Routes::UPLOAD, path: '/upload')]
final readonly class UploadController
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private Responder $responder,
    ) {
    }

    public function __invoke(Request $request, RequestStack $requestStack): Response
    {
        $form = $this->formFactory->create(UploadFormType::class);
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
