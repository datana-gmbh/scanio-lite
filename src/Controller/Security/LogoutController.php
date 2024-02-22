<?php

declare(strict_types=1);

namespace App\Controller\Security;

use App\Routing\Routes;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/logout', name: Routes::LOGOUT)]
final class LogoutController
{
    public function __invoke(): never
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
