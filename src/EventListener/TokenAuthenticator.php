<?php


namespace App\EventListener;


use App\Constant\Messages;
use App\Entity\User;
use App\Security\Authenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class TokenAuthenticator
{
    private $authenticator;
    private $entityManager;

    public function __construct(Authenticator $authenticator, EntityManagerInterface $entityManager)
    {
        $this->authenticator = $authenticator;
        $this->entityManager = $entityManager;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        // validate if the current URL is for a public endpoint
        if ($event->getRequest()->getMethod() == 'OPTIONS' || !(bool)$event->getRequest()->attributes->get('skip_auth')) {
            return;
        }

        $token = $event->getRequest()->headers->get('Authorization');
        if (empty($token)) {
            throw new AccessDeniedHttpException(Messages::ACCESS_DENIED);
        }
        $token = explode(' ', $token);
        if (sizeof($token) <= 1 || strtolower($token[0]) != 'bearer') {
            throw new AccessDeniedHttpException(Messages::ACCESS_DENIED);
        }

        // Return Error 401 "Unauthorized" if authentication fails
        $authToken = $this->authenticator->authenticate($token[1]);
        if ($authToken['code'] > 399) {
            throw new AccessDeniedHttpException($authToken['message']);
        }

        if ($authToken['data']->role != $event->getRequest()->attributes->get('role')) {
            throw new AccessDeniedHttpException(Messages::ACCESS_DENIED);
        }

        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['token' => $authToken['data']->token]);
        if (!$user) {
            throw new AccessDeniedHttpException(Messages::ACCESS_DENIED);
        }

        $event->getRequest()->attributes->set('auth_user', $user);
    }
}