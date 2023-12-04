<?php

declare(strict_types=1);

namespace App\Controller;

use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(name: Routes::DASHBOARD, path: '/dashboard')]
final readonly class DashboardController
{
    public function __construct(
        private Responder $responder,
    ) {
    }

    public function __invoke(Request $request): Response
    {
        return $this->responder->render('dashboard.html.twig');
    }
}
