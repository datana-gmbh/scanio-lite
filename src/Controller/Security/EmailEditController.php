<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Domain\Identifier\EmailId;
use App\Repository\EmailRepositoryInterface;
use OskarStark\Symfony\Http\Responder;
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
