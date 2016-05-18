<?php

namespace TodoListBundle\Repository;

use TodoListBundle\Exception\EntityNotFoundException;
use TodoListBundle\Exception\DataAccessLayerException;

use \Doctrine\ORM\ORMException;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class CommonDoctrineRepository
{
	const DAL_ERROR_MESSAGE = 'An error occured while accessing data.';
	const ENTITY_NOT_FOUND_MESSAGE = 'No entity was found with the given id.';

	/**
	 * @var EntityManager
	 */
	private $doctrineEntityManager;

	/**
	 * @var EntityRepository
	 */
	private $doctrineRepository;

	/**
	 * Gives the doctrine repository.
	 * 
	 * @return EntityRepository
	 */
	protected function getDoctrineRepository()
	{
		return $this->doctrineRepository;
	}

	/**
	 * Gives the doctine entityManager.
	 *
	 * @return EntityManager
	 */
	protected function getDoctrineEntityManager()
	{
		return $this->doctrineRepository;
	}

	/**
	 * Contructor.
	 *
	 * @param EntityRepository $doctrineRepository
	 * @param string $entityName
	 */
	public function __construct(EntityManager $doctrineEntityManager, string $entityName) 
	{
		$this->doctrineEntityManager = $doctrineEntityManager;
		$this->doctrineRepository = $this->doctrineEntityManager->getRepository($entityName);
	}

	/**
	 * Gives all entities.
	 *
	 * @param $offset
	 * @param $limit
	 */
	public function findAll($offset = 0, $limit = null)
	{	try {
			return $this->getDoctrineRepository()->findBy([], null, $limit, $offset);
		} catch (ORMException $e) {
			throw new DataAccessLayerException(DAL_ERROR_MESSAGE, 0, $e);
		}
	}

	/**
	 * Gives entity corresponding to the given identifier if it exists
	 * and null otherwise.
	 *
	 * @param $id int
	 */
	public function getById($id)
	{
		try {
			$entity = $this->getDoctrineRepository()->find($id);
			
			if ($entity === null) {
				throw new EntityNotFoundException(ENTITY_NOT_FOUND_MESSAGE);
			}
		} catch (ORMException $e) {
			throw new DataAccessLayerException(DAL_ERROR_MESSAGE, 0, $e);
		}
	}

	/**
	 * Save or update an entity.
	 *
	 * @param $entity
	 */
	public function persist($entity)
	{
		try {
			$this->getDoctrineEntityManager()
					->persist($entity);
		} catch (ORMException $e) {
			throw new DataAccessLayerException(DAL_ERROR_MESSAGE, 0, $e);
		}
	}

	/**
	 * Delete the given entity.
	 *
	 * @param $entity
	 */
	public function delete($entity)
	{
		try {
			$this->getDoctrineEntityManager()
					->remove($entity);
		} catch (ORMException $e) {
			throw new DataAccessLayerException(DAL_ERROR_MESSAGE, 0, $e);
		}
	}
}