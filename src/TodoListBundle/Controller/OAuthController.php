<?php

namespace TodoListBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
        $this->client->authenticate($request->query->get("code", null));
        return new RedirectResponse($this->get('router')->generate("home", array()));
    }
}