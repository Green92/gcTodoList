<?php

namespace TodoListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * List
 *
 * @ORM\Table(name="todo_list")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class TodoList
{
	const WORK_TYPE = 'work';
	const PERSONAL_TYPE = 'personal';
	const OTHER_TYPE = 'other';
	
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
     
    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=30)
     */
    private $type;

    /**
     * Todos of this list.
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Todo", mappedBy="list")
     */
    private $todos;

    /**
     * Constructor.
     *
     */
    public function __construct() {
        $this->todos = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     *
     * @return List
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return List
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return TodoList
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add todo
     *
     * @param Todo $todo
     *
     * @return TodoList
     */
    public function addTodo(Todo $todo)
    {
        $this->todos[] = $todo;

        return $this;
    }

    /**
     * Remove todo
     *
     * @param Todo $todo
     */
    public function removeTodo(Todo $todo)
    {
        $this->todos->removeElement($todo);
    }

    /**
     * Get todos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTodos()
    {
        return $this->todos;
    }

    public function __toString()
    {
        return $this->type.':'.$this->name;
    }
}
