<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class IndexController extends AbstractController
{
    public function __construct(
        private readonly Responder $responder,
    ) {
    }

    #[Route(path: '/', name: Routes::LOGIN)]
    public function login(#[CurrentUser] ?User $user): Response
    {
        if ($user instanceof User) {
            return $this->responder->route(Routes::DASHBOARD);
        }

        return $this->responder->route(Routes::LOGIN);
    }
}
