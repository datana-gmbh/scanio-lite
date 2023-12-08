<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Crud\Edit\Form\FormTypeFactoryInterface;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Domain\Identifier\DocumentId;
use App\Repository\DocumentRepositoryInterface;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: Routes::EDIT, path: '/edit/{group}/{category}/{documentId}')]
final readonly class EditController
{
    public function __construct(
        private DocumentRepositoryInterface $documents,
        private FormFactoryInterface $formFactory,
        private FormTypeFactoryInterface $formTypeFactory,
        private Responder $responder,
    ) {
    }

    public function __invoke(Request $request, Group $group, Category $category, DocumentId $id): Response
    {
        $document = $this->documents->get($id);

        $formType = $this->formTypeFactory->create($group, $category);

        $form = $this->formFactory->create(
            $formType::class,
            $document,
            [
                'submit_enabled' => !$document->isFinished(),
            ],
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->documents->save($document);

            return $this->responder->redirect($request->getUri());
        }

        return $this->responder->render('default/edit.html.twig', [
            'group' => $group,
            'category' => $category,
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }
}
