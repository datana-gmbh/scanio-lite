<?php

declare(strict_types=1);

namespace App\Controller;

use App\Crud\Edit\Form\FormTypeFactoryInterface;
use App\Domain\Enum\Group;
use App\Domain\Enum\Type;
use App\Domain\Identifier\LetterId;
use App\Repository\LetterRepositoryInterface;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: Routes::EDIT, path: '/edit/{group}/{type}/{letterId}')]
final readonly class EditController
{
    public function __construct(
        private LetterRepositoryInterface $letters,
        private FormFactoryInterface $formFactory,
        private FormTypeFactoryInterface $formTypeFactory,
        private Responder $responder,
    ) {
    }

    public function __invoke(Request $request, Group $group, Type $type, LetterId $id): Response
    {
        $letter = $this->letters->get($id);

        $formType = $this->formTypeFactory->create($group, $type);

        $form = $this->formFactory->create(
            $formType::class,
            $letter,
            [
                'submit_enabled' => !$letter->isFinished(),
            ],
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->letters->save($letter);

            return $this->responder->redirect($request->getUri());
        }

        return $this->responder->render('default/edit.html.twig', [
            'group' => $group,
            'type' => $type,
            'letter' => $letter,
            'form' => $form->createView(),
        ]);
    }
}
