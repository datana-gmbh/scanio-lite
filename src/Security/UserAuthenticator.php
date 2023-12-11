<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use App\Exception\UserNotFound;
use App\Repository\UserRepositoryInterface;
use App\Routing\Routes;
use OskarStark\Symfony\Http\Responder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Webmozart\Assert\Assert;

final class UserAuthenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    public function __construct(
        private readonly Responder $responder,
        private readonly UserRepositoryInterface $users,
    ) {
    }

    public function authenticate(Request $request): Passport
    {
        $password = $request->request->get('password');
        Assert::string($password);

        $email = $request->request->get('email');
        Assert::string($email);

        $rememberMe = $request->request->get('remember_me', false);
        Assert::boolean($rememberMe);

        $csrfToken = $request->request->get('_csrf_token');
        Assert::string($csrfToken);

        $rememberMeBadge = new RememberMeBadge();

        if ($rememberMe) {
            $rememberMeBadge->enable();
        }

        $request->getSession()->set(
            SecurityRequestAttributes::LAST_USERNAME,
            $email,
        );

        return new Passport(
            new UserBadge($email, function (string $email): User {
                try {
                    return $this->users->getByEmail($email);
                } catch (UserNotFound) {
                    throw new UserNotFoundException();
                }
            }),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $csrfToken),
                $rememberMeBadge,
            ],
        );
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->attributes->add([SecurityRequestAttributes::AUTHENTICATION_ERROR => $exception]);

        return null;
    }

    public function supports(Request $request): bool
    {
        return Routes::INDEX === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if (null !== $targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return $this->responder->route(Routes::DASHBOARD);
    }
}
