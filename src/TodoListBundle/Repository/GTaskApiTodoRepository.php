<?php

namespace TodoListBundle\Repository;

use TodoListBundle\Entity\Todo;
use TodoListBundle\Google\Client;
use Google_Service_Tasks;
use Google_Service_Tasks_Task;


class GTaskApiTodoRepository implements ITodoRepository
{
	/**
	 * @var Google_Service_Tasks
	 */
	private $taskService;

	private function convertTask2Todo($task) {
		$todo =  new Todo();

		if(isset($task->id)){
			$todo->setId($task->id);
		}

		if (isset($task->title)) {
			$todo->setDescription($task->title);
		}

		if (isset($task->done)) {
			$todo->setDone($task->done);
		}

		return $todo;
	}

	private function convertTodo2Task(Todo $todo) {
		$task =  new Google_Service_Tasks_Task();

		$task->id = $todo->getId();
		$task->title = $todo->getDescription();
		$task->completed = $todo->getDone();

		return $task;
	}

	public function  __construct(Client $googleClient, $tokenStorage)
	{
		$googleClient->setAccessToken(json_decode($tokenStorage->getToken()->getUser()));
		$this->taskService = new Google_Service_Tasks($googleClient);
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
	public function getById($id, $taskListId = null) {
		$task = $this->taskService->tasks->get($taskListId, $id);
		return $this->convertTask2Todo($task);
	}

	/**
	 * Save or update an entity.
	 *
	 * @param $entity
	 */
	public function persist($entity) {
		if ($entity->getId() == null) {
			$this->taskService->tasks->insert($entity->getList()->getId(), $this->convertTodo2Task($entity));
		} else {
			$this->taskService->tasks->update($entity->getList()->getId(), $this->convertTodo2Task($entity));
		}
	}

	/**
	 * Delete the given entity.
	 *
	 * @param $entity
	 */
	public function delete($entity) {
		$this->taskService->tasks->delete($entity->getList()->getId(), $entity->getId());
	}
}