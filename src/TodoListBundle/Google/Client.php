<?php

namespace TodoListBundle\Google;

use HappyR\Google\ApiBundle\Services\GoogleClient;

class Client
{
	private $client;

	public function __construct(GoogleClient $client) {
		$this->client = $client;
		$this->client->getGoogleClient()->setScopes([
			"https://www.googleapis.com/auth/tasks"
		]);
	}

	public function createAuthUrl() {
		return $this->client->createAuthUrl();
	}

	public function authenticate($code) {
		$this->client->authenticate($code);
	}

	public function getAccesToken() {
		return $this->client->getAccessToken();
	}
}