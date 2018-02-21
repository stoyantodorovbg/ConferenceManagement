<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Conference;
use AppBundle\Entity\ProgramPoint;
use AppBundle\Service\ProgramPointService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Programpoint controller.
 *
 * @Route("programpoint")
 */
class ProgramPointController extends Controller
{
    /**
     * Lists all programPoint entities.
     *
     * @Route("/", name="programpoint_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $programPoints = $em->getRepository('AppBundle:ProgramPoint')->findAll();

        return $this->render('programpoint/index.html.twig', array(
            'programPoints' => $programPoints,
        ));
    }

    /**
     * Creates a new programPoint entity.
     *
     * @Route("/new/{id}", name="programpoint_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $conferenceId = $request->attributes->all()['id'];
        $programPoint = new Programpoint();
        $form = $this->createForm('AppBundle\Form\ProgramPointType', $programPoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programPointService = $this->get(ProgramPointService::class);
            $programPointService->new($programPoint, $conferenceId);

            return $this->redirectToRoute('conference_show', array('id' => $conferenceId));
        }

        return $this->render('programpoint/new.html.twig', array(
            'programPoint' => $programPoint,
            'form' => $form->createView(),
            'conferenceId' => $conferenceId
        ));
    }

    /**
     * Finds and displays a programPoint entity.
     *
     * @Route("/{id}", name="programpoint_show")
     * @Method("GET")
     */
    public function showAction(ProgramPoint $programPoint)
    {
        $deleteForm = $this->createDeleteForm($programPoint);

        return $this->render('programpoint/show.html.twig', array(
            'programPoint' => $programPoint,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing programPoint entity.
     *
     * @Route("/{id}/edit", name="programpoint_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProgramPoint $programPoint)
    {
        $deleteForm = $this->createDeleteForm($programPoint);
        $editForm = $this->createForm('AppBundle\Form\ProgramPointType', $programPoint);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('programpoint_show', array('id' => $programPoint->getId()));
        }

        return $this->render('programpoint/edit.html.twig', array(
            'programPoint' => $programPoint,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a programPoint entity.
     *
     * @Route("/{id}", name="programpoint_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProgramPoint $programPoint)
    {
        $form = $this->createDeleteForm($programPoint);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $programPointService = $this->get(ProgramPointService::class);
            $programPointService->delete($programPoint);
        }

        return $this->redirectToRoute('programpoint_index');
    }

    /**
     * Creates a form to delete a programPoint entity.
     *
     * @param ProgramPoint $programPoint The programPoint entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProgramPoint $programPoint)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('programpoint_delete', array('id' => $programPoint->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
