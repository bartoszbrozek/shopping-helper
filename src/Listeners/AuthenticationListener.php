<?php

namespace App\Listeners;

use DateInterval;
use DateTime;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationListener
{
    private $tokenTTL;
    private $isHTTPOnlySecure = false;

    public function __construct($tokenTTL = 3600)
    {
        $this->tokenTTL = $tokenTTL;
    }

    public function onSuccess(AuthenticationSuccessEvent $event)
    {
        $response = $event->getResponse();
        $data = $event->getData();

        $token = $data['token'];

        $response->headers->setCookie(
            new Cookie(
                'BEARER',
                $token,
                (new DateTime())
                    ->add(new \DateInterval('PT' . $this->tokenTTL . 'S')),
                '/',
                null,
                $this->isHTTPOnlySecure
            )

        );

        return $response;
    }
}
