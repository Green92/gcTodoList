<?php

namespace TodoListBundle\Repository;

interface ICommonRepository
{
	/**
	 * Gives all entities.
	 */
	public function findAll($offset = 0, $limit = null);

	/**
	 * Gives entity corresponding to the given identifier if it exists
	 * and null otherwise.
	 *
	 * @param $id int
	 */
	public function getById($id);

	/**
	 * Save or update an entity.
	 *
	 * @param $entity
	 */
	public function persist($entity);

	/**
	 * Delete the given entity.
	 *
	 * @param $entity
	 */
	public function delete($entity);
}