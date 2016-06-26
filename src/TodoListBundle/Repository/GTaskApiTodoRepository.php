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
	private $todoRepository;

	private function convertTask2Todo(Google_Service_Tasks_Task $task) {
		$todo =  new Todo();
		
		$todo->setId($task->getId());
		$todo->setDescription($task->getTitle());
		$todo->setDone($task->getStatus() === 'completed');

		$todo->setList($this->todoRepository->getById('@default'));

		return $todo;
	}

	private function convertTodo2Task(Todo $todo) {
		$task =  new Google_Service_Tasks_Task();

		$task->setKind('tasks#task');

		$date = new \DateTime();
		$date->format(\DateTime::RFC3339);

		if ($todo->getId() == null) {
			$task->setId($todo->getId());
		}

		$task->setTitle($todo->getDescription());
		$task->setDue($date);
		$task->setNotes($todo->getDescription());
		$task->setDeleted(false);
		$task->setHidden(false);
		$task->setParent('@default');
		$task->setUpdated($date);

		$task->setStatus($todo->getDone() ? 'completed' : 'needsAction');
		$task->setCompleted($date);


		return $task;
	}

	public function  __construct(Client $googleClient, ITodoListRepository $todoListRepository, $tokenStorage)
	{
		$googleClient->setAccessToken(json_decode($tokenStorage->getToken()->getUser(), true));
		$this->taskService = $googleClient->getTaskService();
		$this->todoRepository = $todoListRepository;
	}

	/**
	 * Gives all entities.
	 */
	public function findAll($offset = 0, $limit = null) {
		$tasks = $this->taskService->tasks->listTasks('@default');

		$result = [];

		foreach ($tasks as $task) {
			$result[] = $this->convertTask2Todo($task);
		}

		return $result;
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
		$task = $this->convertTodo2Task($entity);

		if ($entity->getId() == null) {
			$task = $this->taskService->tasks->insert($task->getParent(), $task);
			$entity->setId($task->getId());
		} else {
			$this->taskService->tasks->update($task->getParent(), $task->getId(), $task);
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