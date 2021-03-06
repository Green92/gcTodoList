<?php

namespace TodoListBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TodoListBundle\Entity\TodoList;
use TodoListBundle\Form\TodoListType;

use TodoListBundle\Repository\ITodoListRepository;

/**
 * TodoList controller.
 *
 * @Route("/todolist", service="todo_list.todo_list_controller")
 */
class TodoListController extends Controller
{
    /**
     * @var ITodoListRepository
     */
    private $todoListRepository;

    /**
     * Constructor
     *
     * @param ITodoListRepository $todoListRepository;
     */
    public function __construct(ITodoListRepository $todoListRepository)
    {
        $this->todoListRepository = $todoListRepository;
    }

    /**
     * Lists all TodoList entities.
     *
     * @Route("/", name="todolist_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $todoLists = $this->todoListRepository->findAll();

        return $this->render('todolist/index.html.twig', array(
            'todoLists' => $todoLists,
        ));
    }

    /**
     * Creates a new TodoList entity.
     *
     * @Route("/new", name="todolist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $todoList = new TodoList();
        $form = $this->createForm('TodoListBundle\Form\TodoListType', $todoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->todoListRepository->persist($todoList);

            return $this->redirectToRoute('todolist_show', array('id' => $todoList->getId()));
        }

        return $this->render('todolist/new.html.twig', array(
            'todoList' => $todoList,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TodoList entity.
     *
     * @Route("/{id}", name="todolist_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $todoList = $this->todoListRepository->getById($id);

        $deleteForm = $this->createDeleteForm($todoList);

        return $this->render('todolist/show.html.twig', array(
            'todoList' => $todoList,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing TodoList entity.
     *
     * @Route("/{id}/edit", name="todolist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $todoList = $this->todoListRepository->getById($id);
        $deleteForm = $this->createDeleteForm($todoList);
        $editForm = $this->createForm('TodoListBundle\Form\TodoListType', $todoList);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->todoListRepository->persist($todoList);

            return $this->redirectToRoute('todolist_edit', array('id' => $todoList->getId()));
        }

        return $this->render('todolist/edit.html.twig', array(
            'todoList' => $todoList,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a TodoList entity.
     *
     * @Route("/{id}", name="todolist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $todoList = $this->todoListRepository->getById($id);
        $form = $this->createDeleteForm($todoList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->todoListRepository->delete($todoList);
        }

        return $this->redirectToRoute('todolist_index');
    }

    /**
     * Creates a form to delete a TodoList entity.
     *
     * @param TodoList $todoList The TodoList entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(TodoList $todoList)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('todolist_delete', array('id' => $todoList->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
