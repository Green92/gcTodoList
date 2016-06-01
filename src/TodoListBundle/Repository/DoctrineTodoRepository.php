<?php

namespace TodoListBundle\Repository;

use Doctrine\ORM\EntityManager;

class DoctrineTodoRepository extends CommonDoctrineRepository implements ITodoRepository
{
	/**
	 * Constructor.
	 *
	 * @param EntityManager $doctrineEntityManager
	 */
	public function __construct(EntityManager $doctrineEntityManager)
	{
		parent::__construct($doctrineEntityManager, 'TodoListBundle\Entity\Todo');
	}

	
}