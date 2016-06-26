<?php

namespace TodoListBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use TodoListBundle\Entity\Todo;
use TodoListBundle\Form\TodoType;

use TodoListBundle\Repository\ITodoRepository;

/**
 * Todo controller.
 *
 * @Route("/todo", service="todo_list.todo_controller")
 */
class TodoController extends Controller
{
    /**
     * @var ITodoRepository
     */
    private $todoRepository;

    public function __construct(ITodoRepository $todoRepository)
    {
        $this->todoRepository = $todoRepository;
    }

    /**
     * Lists all Todo entities.
     *
     * @Route("/", name="todo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $todos = $this->todoRepository->findAll();

        return $this->render('todo/index.html.twig', array(
            'todos' => $todos,
        ));
    }

    /**
     * Creates a new Todo entity.
     *
     * @Route("/new", name="todo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $todo = new Todo();
        $form = $this->createForm('TodoListBundle\Form\TodoType', $todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->todoRepository->persist($todo);

            return $this->redirectToRoute('todo_show', array('id' => $todo->getId()));
        }

        return $this->render('todo/new.html.twig', array(
            'todo' => $todo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Todo entity.
     *
     * @Route("/{id}", name="todo_show")
     * @Method("GET")
     */
    public function showAction($id)
    {
        $todo = $this->todoRepository->getById($id, '@default');
        $deleteForm = $this->createDeleteForm($todo);

        return $this->render('todo/show.html.twig', array(
            'todo' => $todo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Todo entity.
     *
     * @Route("/{id}/edit", name="todo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $todo = $this->todoRepository->getById($id, '@default');
        $deleteForm = $this->createDeleteForm($todo);
        $editForm = $this->createForm('TodoListBundle\Form\TodoType', $todo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->todoRepository->persist($todo);

            return $this->redirectToRoute('todo_edit', array('id' => $todo->getId()));
        }

        return $this->render('todo/edit.html.twig', array(
            'todo' => $todo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Todo entity.
     *
     * @Route("/{id}", name="todo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $todo = $this->todoRepository->getById($id, '@default');
        $form = $this->createDeleteForm($todo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->todoRepository->delete($todo);
        }

        return $this->redirectToRoute('todo_index');
    }

    /**
     * Creates a form to delete a Todo entity.
     *
     * @param Todo $todo The Todo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Todo $todo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('todo_delete', array('id' => $todo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
