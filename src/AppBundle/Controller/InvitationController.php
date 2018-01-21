<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Invitation;
use AppBundle\Service\InvitationService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Invitation controller.
 *
 * @Route("invitation")
 */
class InvitationController extends Controller
{
    /**
     * Lists all invitation entities.
     *
     * @Route("/", name="invitation_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $invitations = $em->getRepository('AppBundle:Invitation')->findAll();

        return $this->render('invitation/index.html.twig', array(
            'invitations' => $invitations,
        ));
    }

    /**
     * Creates a new invitation entity.
     *
     * @Route("/new", name="invitation_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR', 'ROLE_CONFERENCE_OWNER', 'ROLE_CONFERENCE_ADMIN'])")
     */
    public function newAction(Request $request)
    {
        $conferenceId = $request->query->all()['id'];
        $invitation = new Invitation();
        $form = $this->createForm('AppBundle\Form\InvitationType', $invitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invitationService = $this->get(InvitationService::class);
            $invitationService->new($invitation, $conferenceId);

            return $this->redirectToRoute('invitation_show', array('id' => $invitation->getId()));
        }

        return $this->render('invitation/new.html.twig', array(
            'invitation' => $invitation,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a invitation entity.
     *
     * @Route("/{id}", name="invitation_show")
     * @Method("GET")
     */
    public function showAction(Invitation $invitation)
    {
        $deleteForm = $this->createDeleteForm($invitation);

        return $this->render('invitation/show.html.twig', array(
            'invitation' => $invitation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * @Route("/approve/{id}", name="approve_invitation")
     * @Method("GET")
     */
    public function approve(Invitation $invitation)
    {
        $user = $this->getUser();
        $invitationService = $this->get(InvitationService::class);
        $invitationService->approve($invitation, $user);

        return $this->redirectToRoute('user_show');
    }



    /**
     * @Route("/refuse/{id}", name="refuse_invitation")
     * @Method("GET")
     */
    public function refuse(Invitation $invitation)
    {
        $user = $this->getUser();
        $invitationService = $this->get(InvitationService::class);
        $invitationService->refuse($invitation, $user);

        return $this->redirectToRoute('user_show');
    }

    /**
     * Displays a form to edit an existing invitation entity.
     *
     * @Route("/{id}/edit", name="invitation_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR', 'ROLE_CONFERENCE_OWNER', 'ROLE_CONFERENCE_ADMIN'])")
     */
    public function editAction(Request $request, Invitation $invitation)
    {
        $deleteForm = $this->createDeleteForm($invitation);
        $editForm = $this->createForm('AppBundle\Form\InvitationType', $invitation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('invitation_edit', array('id' => $invitation->getId()));
        }

        return $this->render('invitation/edit.html.twig', array(
            'invitation' => $invitation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a invitation entity.
     *
     * @Route("/{id}", name="invitation_delete")
     * @Method("DELETE")
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR', 'ROLE_CONFERENCE_OWNER', 'ROLE_CONFERENCE_ADMIN'])")
     */
    public function deleteAction(Request $request, Invitation $invitation)
    {
        $form = $this->createDeleteForm($invitation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $invitationService = $this->get(InvitationService::class);
            $invitationService->delete($invitation);
        }

        return $this->redirectToRoute('invitation_index');
    }

    /**
     * Creates a form to delete a invitation entity.
     *
     * @param Invitation $invitation The invitation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Invitation $invitation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('invitation_delete', array('id' => $invitation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
