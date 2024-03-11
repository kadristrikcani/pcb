<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ErrorToHomepageListener
{

    private RouterInterface $router;
    private string $environment;

    public function __construct(RouterInterface $router, KernelInterface $kernel)
    {
        $this->router = $router;
        $this->environment = $kernel->getEnvironment();
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof HttpExceptionInterface && $this->environment != 'dev') {
            $response = new RedirectResponse($this->router->generate('app_home'));
        } else {
            return;
        }
        $event->setResponse($response);
    }
}