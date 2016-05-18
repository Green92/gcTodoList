<?php

namespace TodoListBundle\Repository;

use TodoListBundle\Exception\NotImplementedException;

use Doctrine\ORM\EntityRepository;

/**
 * DatabaseTodoListRepository
 *
 */
class DatabaseTodoListRepository implements TodoListRepository
{
	private $repository;

	public function __construct(EntityRepository $repository) {
		$this->repository = $repository;
	}

	/**
	 * Gives all the lists.
	 */
	public function findAll($offset = 0, $limit = null) {
		throw new NotImplementedException();
	}
	
	/**
	 * Search for lists by their names.
	 */
	public function searchByName($name, $offset = 0, $limit = null) {
		throw new NotImplementedException();
	}
	
	/**
	 * Gives all lists of the given type.
	 */
	public function findByType($type, $offset = 0, $limit = null) {
		throw new NotImplementedException();
	}
	
	/**
	 * Gives the list corresponding to the given identifier if it exists
	 * and null otherwise.
	 */
	public function getById($id) {
		throw new NotImplementedException();
	}
}
