<?php

namespace TodoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use TodoListBundle\Google\Client;

/**
 * OAuth controller.
 *
 * @Route("/oauth", service="todo_list.oauth_controller")
 */
class OAuthController extends Controller
{
	private $client;

	public function __construct(Client $client) {
		$this->client = $client;
	}

    /**
     * @Route("/callback")
     */
    public function OAuthCallbackAction(Request $request)
    {
        if ($request->query->get('error', null) != null) {
            return new Response('Erreur');
        }

        $this->client->authenticate($request->query->get("code", null));

        $accessToken = $this->client->getAccesToken();

        $securityContext = $this->get('security.token_storage');

        $token = $securityContext->getToken();
        $token = new PreAuthenticatedToken(json_encode($accessToken), $token->getCredentials(), $token->getProviderKey(), ['ROLE_HAS_TOKEN']);

        $securityContext->setToken($token);

        return new RedirectResponse($this->get('router')->generate("home", array()));
    }

    /**
     * @Route("/logout")
     */
    public function OAuthLogoutAction() {
        $security = $this->get('security.token_storage');
        $security->setToken(null);
        $this->get('session')->invalidate();

        return new RedirectResponse($this->get('router')->generate("home", array()));
    }
}