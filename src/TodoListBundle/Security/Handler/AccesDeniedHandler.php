<?php

namespace TodoListBundle\Security\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;
use TodoListBundle\Google\Client;

class AccesDeniedHandler implements AccessDeniedHandlerInterface
{
	private $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}

	public function handle(Request $request, AccessDeniedException $accessDeniedException) {
		return new RedirectResponse($this->client->createAuthUrl());
	}

	public function onKernelException(GetResponseForExceptionEvent $event) {
		if ($event->getException() instanceof \Google_Auth_Exception ||
			$event->getException() instanceof \GoogleServiceException) {
			
			$event->setResponse(
				new RedirectResponse(
					$this->client->createAuthUrl()
				)
			);
		}
	}
}