<?php
namespace App\Security;

use App\Entity\UserToken;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class TokenAuthenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    private $entityManager;
    private $urlGenerator;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization') && str_starts_with($request->headers->get('Authorization'), 'Bearer');
    }

    public function authenticate(Request $request): Passport
    {
        $requestData = json_decode($request->getContent(), true);

//        $apiToken = $request->headers->get('X-AUTH-TOKEN');
        $apiToken = $requestData['token'];
        if (null === $apiToken) {
            // The token header was empty, authentication fails with HTTP Status
            // Code 401 "Unauthorized"
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        // Implement your own logic to get the user identifier from `$apiToken`
        // e.g. by looking up a user in the database using its API key
        $userRepository = $this->entityManager->getRepository(UserToken::class);
        $user = $userRepository->findOneBy(['token' => $apiToken]);
        
        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Invalid API token');
        }

        if ($user->getExpiration() && $user->getExpiration() < new \DateTime()) {
            throw new CustomUserMessageAuthenticationException('Token has expired');
        }

        $userIdentifier = $user->getUsername(); // Assuming getUsername() returns the user identifier
        
        return new SelfValidatingPassport(new UserBadge($userIdentifier));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Optionally, handle success authentication (e.g., redirect the user to a specific page)
        return null;
    }
    
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // Optionally, handle failed authentication (e.g., return a JSON response with an error message)
        return null;
    }

    public function start(Request $request, AuthenticationException $authException = null): ?Response
    {
        // Optionally, handle the case where authentication is required but not provided (e.g., return a JSON response with a 401 status code)
        return null;
    }
}
