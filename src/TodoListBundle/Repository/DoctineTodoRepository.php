<?php

namespace TodoListBundle\Repository;

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