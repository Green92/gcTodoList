<?php

namespace TodoListBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Symfony\Component\HttpFoundation\Request;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationFailureHandlerInterface
{
	public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey) {
		return new PreAuthenticatedToken(
			'ano.',
			null,
			$providerKey,
			[]
		);
	}

	public function createToken(Request $request, $providerKey) {
		return new PreAuthenticatedToken(
			'ano.',
			null,
			$providerKey
		);
	}

	public function supportsToken(TokenInterface $token, $providerKey) {
		return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
		return new Response("Authentication Failed.", 403);
	}
}