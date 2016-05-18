<?php

namespace TodoListBundle\Repository;

use TodoListBundle\Exception\NotImplementedException;

use Doctrine\ORM\EntityManager;
use Doctrine\Common\Collections\Criteria;

/**
 * DatabaseTodoListRepository
 *
 */
class DoctrineTodoListRepository extends CommonDoctrineRepository implements ITodoListRepository
{
	/**
	 * Constructor.
	 *
	 * @param EntityManager $doctrineEntityManager
	 */
	public function __construct(EntityManager $doctrineEntityManager) {
		parent::__construct($doctrineEntityManager, 'TodoListBundle\Entity\TodoList');
	}
	
	/**
	 * Search for lists by their names.
	 */
	public function searchByName($name, $offset = 0, $limit = null) {
		try {
			$criteria = Criteria::create();
			$criteria->where(Criteria::expr()->like('name', sprintf("%s%%", $name)));

			return $this->getDoctrineRepository()->findBy([$criteria], null, $limit, $offset);
		} catch (ORMException $e) {
			throw new DataAccessLayerException(DAL_ERROR_MESSAGE, 0, $e);
		}
	}
	
	/**
	 * Gives all lists of the given type.
	 */
	public function findByType($type, $offset = 0, $limit = null) {
		try {
			$criteria = Criteria::create();
			$criteria->where(Criteria::expr()->eq('type', $type));

			return $this->getDoctrineRepository()->findBy([$criteria], null, $limit, $offset);
		} catch (ORMException $e) {
			throw new DataAccessLayerException(DAL_ERROR_MESSAGE, 0, $e);
		}
	}
}
