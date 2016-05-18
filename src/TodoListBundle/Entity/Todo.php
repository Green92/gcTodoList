<?php

namespace TodoListBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Todo
 *
 * @ORM\Table(name="todo")
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 */
class Todo
{
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
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="done", type="boolean", options={ "default": false })
     */
    private $done;

    /**
     * The list this todo belongs to.
     *
     * @var TodoList
     *
     * @ORM\ManyToOne(targetEntity="TodoList", inversedBy="todos")
     * @ORM\JoinColumn(name="todo_list_id", referencedColumnName="id")
     */
    private $list;


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
     * Set description
     *
     * @param string $description
     *
     * @return Todo
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set done
     *
     * @param boolean $done
     *
     * @return Todo
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * Get done
     *
     * @return bool
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * Set list
     *
     * @param \TodoListBundle\Entity\TodoList $list
     *
     * @return Todo
     */
    public function setList(\TodoListBundle\Entity\TodoList $list = null)
    {
        $this->list = $list;

        return $this;
    }

    /**
     * Get list
     *
     * @return \TodoListBundle\Entity\TodoList
     */
    public function getList()
    {
        return $this->list;
    }
}
