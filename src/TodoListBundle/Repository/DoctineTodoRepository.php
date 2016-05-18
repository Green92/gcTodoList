<?php

namespace TodoListBundle\Repository;

class DoctrineTodoRepository extends CommonDoctrineRepository
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