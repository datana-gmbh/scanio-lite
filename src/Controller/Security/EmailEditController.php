<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Crud\Edit\Form\FormTypeFactoryInterface;
use App\Crud\Edit\Form\Types\Default\Pending;
use App\Domain\Enum\Category;
use App\Domain\Enum\Group;
use App\Domain\Event\DocumentFinishedEvent;
use App\Domain\Identifier\DocumentId;
use App\Domain\Identifier\EmailId;
use App\Repository\DocumentRepositoryInterface;
use App\Repository\EmailRepositoryInterface;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: 'fooo', path: '/emails/{emailId}')]
final readonly class EmailEditController
{
    public function __construct(
        private EmailRepositoryInterface $emails,
        private Responder $responder,
    ) {
    }

    public function __invoke(Request $request, EmailId $id): Response
    {
        $email = $this->emails->get($id);

        return $this->responder->render('secured/email/edit.html.twig', [
            'email' => $email,
        ]);
    }
}
