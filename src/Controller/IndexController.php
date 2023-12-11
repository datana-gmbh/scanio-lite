<?php

declare(strict_types=1);

namespace App\Controller;

use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(path: '/', name: Routes::INDEX)]
final readonly class IndexController
{
    public function __construct(
        private Responder $responder,
        private AuthenticationUtils $authenticationUtils,
    ) {
    }

    public function __invoke(): Response
    {
        // get the login error if there is one
        $error = $this->authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $this->authenticationUtils->getLastUsername();

        return $this->responder->render('page/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }
}
