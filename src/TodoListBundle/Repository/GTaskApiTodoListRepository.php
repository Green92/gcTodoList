<?php
/**
 * Created by PhpStorm.
 * User: greg
 * Date: 26/06/16
 * Time: 17:21
 */

namespace TodoListBundle\Repository;

use Google_Service_Tasks;
use Google_Service_Tasks_TaskList;
use TodoListBundle\Entity\TodoList;

use TodoListBundle\Google\Client;

class GTaskApiTodoListRepository implements ITodoListRepository
{
    private $taskService;

    private function convertTaskList2TodoList(Google_Service_Tasks_TaskList $taskList) {
        $todoList = new TodoList();

        $todoList->setName($taskList->getTitle());
        $todoList->setType($taskList->getKind());
        $todoList->setId($taskList->getId());

        return $todoList;
    }

    private function convertTodoList2TaskList(TodoList $todoList) {

        $taskList = new Google_Service_Tasks_TaskList();

        $taskList->setId($todoList->getId());
        $taskList->setTitle($todoList->getName());
        $taskList->setKind($todoList->getType());

        return $taskList;
    }

    /**
     * GTaskApiTodoListRepository constructor.
     */
    public function __construct(Client $googleClient, $tokenStorage)
    {
        $googleClient->setAccessToken(json_decode($tokenStorage->getToken()->getUser(), true));
        $this->taskService = $googleClient->getTaskService();
    }

    public function findAll($offset = 0, $limit = null)
    {
        $lists = $this->taskService->tasklists->listTasklists();

        $result = [];

        foreach ($lists as $list) {
            $result[] = $this->convertTaskList2TodoList($list);
        }

        return $result;
    }

    public function getById($id, $taskId = null)
    {
        return $this->convertTaskList2TodoList($this->taskService->tasklists->get($id));
    }

    public function persist($entity)
    {
        $taskList = $this->convertTodoList2TaskList($entity);

        if ($entity->getId() == null) {
            $taskList = $this->taskService->tasklists->insert($taskList);
            $entity->setId($taskList->getId());
        } else {
            $this->taskService->tasklists->update($taskList->getId(), $taskList);
        }
    }

    public function delete($entity)
    {
        $this->taskService->tasklists->delete($entity->getId());
    }

    public function searchByName($name, $offset = 0, $limit = null)
    {
        // TODO: Implement searchByName() method.
    }

    public function findByType($type, $offset = 0, $limit = null)
    {
        // TODO: Implement findByType() method.
    }
}