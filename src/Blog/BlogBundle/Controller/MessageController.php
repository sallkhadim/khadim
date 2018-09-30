<?php

namespace Blog\BlogBundle\Controller;

use Blog\BlogBundle\Entity\Message;
use Blog\BlogBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Message controller.
 *
 * @Route("message")
 */
class MessageController extends Controller
{
    /**
     * Lists all message entities.
     *
     * @Route("/", name="message_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('BlogBundle:Message')->findAll();

        return $this->render('message/index.html.twig', array(
            'messages' => $messages,
        ));
    }

    /**
     * Lists all message entities.
     *
     * @Route("/", name="message_politique")
     * @Method("GET")
     */
    public function politiqueAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('BlogBundle:Message')->findAll();

        return $this->render('message/politique.html.twig', array(
            'messages' => $messages,
        ));
    }

        /**
         * Lists all message entities.
         *
         * @Route("/", name="message_deve")
         * @Method("GET")
         */
        public function deveAction()
        {
            $em = $this->getDoctrine()->getManager();

            $messages = $em->getRepository('BlogBundle:Message')->findAll();

            return $this->render('message/deve.html.twig', array(
                'messages' => $messages,
            ));
        }

    /**
     * Lists all message entities.
     *
     * @Route("/", name="message_sport")
     * @Method("GET")
     */
    public function sportAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('BlogBundle:Message')->findAll();

        return $this->render('message/sport.html.twig', array(
            'messages' => $messages,
        ));
    }

    /**
     * Lists all message entities.
     *
     * @Route("/", name="message_securite")
     * @Method("GET")
     */
    public function securiteAction()
    {
        $em = $this->getDoctrine()->getManager();

        $messages = $em->getRepository('BlogBundle:Message')->findAll();

        return $this->render('message/securite.html.twig', array(
            'messages' => $messages,
        ));
    }


    /**
     * Creates a new message entity.
     *
     * @Route("/new", name="message_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $message = new Message();
        $form = $this->createForm('Blog\BlogBundle\Form\MessageType', $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->uploadProfilePicture();
            $em->persist($message);
            $em->flush();

            return $this->redirectToRoute('message_show', array('id' => $message->getId()));
        }

        return $this->render('message/new.html.twig', array(
            'message' => $message,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a message entity.
     *
     * @Route("/{id}", name="message_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Message $message, Request $request)
    {
        $comment = new Comment();
        $form = $this->createForm('Blog\BlogBundle\Form\CommentType', $comment);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('BlogBundle:Comment')->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setMessage($message);
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('message_show', array('id' => $message->getId()));
        }

        $deleteForm = $this->createDeleteForm($message);

        return $this->render('message/show.html.twig', array(
            'message' => $message,
            'delete_form' => $deleteForm->createView(),
            'comment1' => $form->createView(),
            'comments' => $comments,
        ));
    }

    /**
     * Displays a form to edit an existing message entity.
     *
     * @Route("/{id}/edit", name="message_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Message $message)
    {
        $deleteForm = $this->createDeleteForm($message);
        $editForm = $this->createForm('Blog\BlogBundle\Form\MessageType', $message);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $message->uploadProfilePicture();
            $em->flush();

            return $this->redirectToRoute('message_show', array('id' => $message->getId()));
        }

        return $this->render('message/edit.html.twig', array(
            'message' => $message,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a message entity.
     *
     * @Route("/{id}", name="message_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Message $message)
    {
        $form = $this->createDeleteForm($message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($message);
            $em->flush();
        }

        return $this->redirectToRoute('message_index');
    }

    /**
     * Creates a form to delete a message entity.
     *
     * @param Message $message The message entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    public function createDeleteForm(Message $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('message_delete', array('id' => $message->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
