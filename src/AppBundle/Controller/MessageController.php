<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Service\MessageService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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

        $messages = $em->getRepository('AppBundle:Message')->findAll();

        return $this->render('message/index.html.twig', array(
            'messages' => $messages,
        ));
    }

    /**
     * Lists received message entities to the user.
     *
     * @Route("/receivedMessages", name="messages_received")
     * @Method("GET")
     */
    public function showReceivedMessages()
    {
        $messageService = $this->get(MessageService::class);
        $messages = $messageService->showReceivedMessages($this->getUser());

        return $this->render('message/receivedMessages.html.twig', array(
            'messages' => $messages,
        ));

    }

    /**
     * Lists received message entities to the user.
     *
     * @Route("/sentMessages", name="messages_sent")
     * @Method("GET")
     */
    public function showSentMessages()
    {
        $messageService = $this->get(MessageService::class);
        $messages = $messageService->showSentMessages($this->getUser());

        return $this->render('message/sentMessages.html.twig', array(
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
        $form = $this->createForm('AppBundle\Form\MessageType', $message);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $messageService = $this->get(MessageService::class);
            $messageService->newMessage($message, $this->getUser());

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
     * @Method("GET")
     */
    public function showAction(Message $message)
    {
        $deleteForm = $this->createDeleteForm($message);

        return $this->render('message/show.html.twig', array(
            'message' => $message,
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
            $messageService = $this->get(MessageService::class);
            $messageService->deleteMessage($message);
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
    private function createDeleteForm(Message $message)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('message_delete', array('id' => $message->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
