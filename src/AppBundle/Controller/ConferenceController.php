<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conference;
use AppBundle\Service\ConferenceService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Conference controller.
 *
 * @Route("conference")
 */
class ConferenceController extends Controller
{
    /**
     * Lists all conference entities.
     *
     * @Route("/", name="conference_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $conferences = $em->getRepository('AppBundle:Conference')->findAll();

        return $this->render('conference/index.html.twig', array(
            'conferences' => $conferences,
        ));
    }

    /**
     * Creates a new conference entity.
     *
     * @Route("/new", name="conference_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR'])")
     */
    public function newAction(Request $request)
    {
        $conference = new Conference();
        $form = $this->createForm('AppBundle\Form\ConferenceType', $conference);
        $form->handleRequest($request);

        if ($form->isSubmitted()){// && $form->isValid()) {
            $conferenceService = $this->get(ConferenceService::class);
            $conferenceService->new($conference);

            return $this->redirectToRoute('conference_show', array('id' => $conference->getId()));
        }

        return $this->render('conference/new.html.twig', array(
            'conference' => $conference,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a conference entity.
     *
     * @Route("/{id}", name="conference_show")
     * @Method("GET")
     */
    public function showAction(Conference $conference)
    {
        $deleteForm = $this->createDeleteForm($conference);

        return $this->render('conference/show.html.twig', array(
            'conference' => $conference,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing conference entity.
     *
     * @Route("/{id}/edit", name="conference_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR', 'ROLE_CONFERENCE_OWNER', 'ROLE_CONFERENCE_ADMIN'])")
     */
    public function editAction(Request $request, Conference $conference)
    {
        $userRoles = $this->getUser()->getRoles();

        $isAuthenticated = false;
        foreach($userRoles as $role) {
            if ($role == 'ROLE_SITE_ADMIN' || $role = 'ROLE_SITE_EDITOR') {
                $isAuthenticated = true;
            }
        }

        $conferenceEditors = $conference->getEditors();
        $conferenceAdmins = $conference->getAdmins();
        $conferenceOwner = $conference->getOwner();

        if (!$isAuthenticated) {

        }
        $deleteForm = $this->createDeleteForm($conference);
        $editForm = $this->createForm('AppBundle\Form\ConferenceType', $conference);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('conference_show', array('id' => $conference->getId()));
        }

        return $this->render('conference/edit.html.twig', array(
            'conference' => $conference,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a conference entity.
     *
     * @Route("/{id}", name="conference_delete")
     * @Method("DELETE")
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR'])")
     */
    public function deleteAction(Request $request, Conference $conference)
    {
        $form = $this->createDeleteForm($conference);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $conferenceService = $this->get(ConferenceService::class);
            $conferenceService->delete($conference);
        }

        return $this->redirectToRoute('conference_index');
    }

    /**
     * Creates a form to delete a conference entity.
     *
     * @param Conference $conference The conference entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Conference $conference)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('conference_delete', array('id' => $conference->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
