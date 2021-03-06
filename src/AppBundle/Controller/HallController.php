<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Hall;
use AppBundle\Service\HallService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Hall controller.
 *
 * @Route("hall")
 */
class HallController extends Controller
{
    /**
     * Lists all hall entities.
     *
     * @Route("/", name="hall_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $halls = $em->getRepository('AppBundle:Hall')->findAll();

        return $this->render('hall/index.html.twig', array(
            'halls' => $halls,
        ));
    }

    /**
     * Creates a new hall entity.
     *
     * @Route("/new", name="hall_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR', 'ROLE_CONFERENCE_OWNER', 'ROLE_CONFERENCE_ADMIN'])")
     */
    public function newAction(Request $request)
    {
        $conferenceId = $request->query->all()['id'];
        $hall = new Hall();
        $form = $this->createForm('AppBundle\Form\HallType', $hall);
        $form->handleRequest($request);

        if ($form->isSubmitted()){// && $form->isValid()) {
            $hallService = $this->get(HallService::class);
            $hallService->new($hall);

            return $this->redirectToRoute('conference_edit', array('id' => $conferenceId));
        }

        return $this->render('hall/new.html.twig', array(
            'hall' => $hall,
            'form' => $form->createView(),
            'conferenceId' => $conferenceId,
        ));
    }

    /**
     * Finds and displays a hall entity.
     *
     * @Route("/{id}", name="hall_show")
     * @Method("GET")
     */
    public function showAction(Hall $hall)
    {
        $deleteForm = $this->createDeleteForm($hall);

        return $this->render('hall/show.html.twig', array(
            'hall' => $hall,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing hall entity.
     *
     * @Route("/{id}/edit", name="hall_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR', 'ROLE_CONFERENCE_OWNER', 'ROLE_CONFERENCE_ADMIN'])")
     */
    public function editAction(Request $request, Hall $hall)
    {
        $deleteForm = $this->createDeleteForm($hall);
        $editForm = $this->createForm('AppBundle\Form\HallType', $hall);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('hall_edit', array('id' => $hall->getId()));
        }

        return $this->render('hall/edit.html.twig', array(
            'hall' => $hall,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a hall entity.
     *
     * @Route("/{id}", name="hall_delete")
     * @Method("DELETE")
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR'])")
     */
    public function deleteAction(Request $request, Hall $hall)
    {
        $form = $this->createDeleteForm($hall);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hallService = $this->get(HallService::class);
            $hallService->delete($hall);
        }

        return $this->redirectToRoute('hall_index');
    }

    /**
     * Creates a form to delete a hall entity.
     *
     * @param Hall $hall The hall entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Hall $hall)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('hall_delete', array('id' => $hall->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
