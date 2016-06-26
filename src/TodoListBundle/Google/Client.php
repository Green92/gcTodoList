<?php

namespace TodoListBundle\Google;

use HappyR\Google\ApiBundle\Services\GoogleClient;

use Google_Service_Tasks;

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

	public function getAccessToken() {
		return $this->client->getAccessToken();
	}

	public function setAccessToken($token) {
		return $this->client->setAccessToken($token);
	}

	public function getTaskService() {
		return new Google_Service_Tasks($this->client->getGoogleClient());
	}
}