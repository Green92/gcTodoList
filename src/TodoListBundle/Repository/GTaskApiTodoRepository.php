<?php

namespace TodoListBundle\Repository;

use TodoListBundle\Google\Client;

use TodoListBundle\Exception\NotImplementedException;

class GTaskApiTodoRepository implements ITodoRepository
{
	/**
	 * @var Google_Service_Tasks
	 */
	private $taskService;

	public function  __construct(Client $googleClient)
	{
		//$this->taskService = new Google_Service_Tasks($googleClient);
	}

	/**
	 * Gives all entities.
	 */
	public function findAll($offset = 0, $limit = null) {
		return $this->taskService->listTasks('@default');
	}

	/**
	 * Gives entity corresponding to the given identifier if it exists
	 * and null otherwise.
	 *
	 * @param $id int
	 */
	public function getById($id) {
		throw new NotImplementedException();
	}

	/**
	 * Save or update an entity.
	 *
	 * @param $entity
	 */
	public function persist($entity) {
		throw new NotImplementedException();
	}

	/**
	 * Delete the given entity.
	 *
	 * @param $entity
	 */
	public function delete($entity) {
		throw new NotImplementedException();
	}
}