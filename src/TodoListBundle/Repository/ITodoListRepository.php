<?php

namespace TodoListBundle\Repository;

/**
 * ITodoListRepository
 *
 */
interface ITodoListRepository extends ICommonRepository
{	
	/**
	 * Search for lists by their names.
	 */
	public function searchByName($name, $offset = 0, $limit = null);
	
	/**
	 * Gives all lists of the given type.
	 */
	public function findByType($type, $offset = 0, $limit = null);
}
