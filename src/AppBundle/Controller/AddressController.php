<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Service\AddressService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Address controller.
 *
 * @Route("address")
 */
class AddressController extends Controller
{
    /**
     * Lists all address entities.
     *
     * @Route("/", name="address_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $addresses = $em->getRepository('AppBundle:Address')->findAll();

        return $this->render('address/index.html.twig', array(
            'addresses' => $addresses,
        ));
    }

    /**
     * Creates a new address entity.
     *
     * @Route("/new", name="address_new")
     * @Method({"GET", "POST"})
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR', 'ROLE_CONFERENCE_OWNER', 'ROLE_CONFERENCE_ADMIN'])")
     */
    public function newAction(Request $request)
    {
        $hallId = $request->query->all()['id'];
        $address = new Address();
        $form = $this->createForm('AppBundle\Form\AddressType', $address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addressService = $this->get(AddressService::class);
            $addressService->new($address);

            return $this->redirectToRoute('conference_edit', array('id' => $hallId));
        }

        return $this->render('address/new.html.twig', array(
            'address' => $address,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a address entity.
     *
     * @Route("/{id}", name="address_show")
     * @Method("GET")
     */
    public function showAction(Address $address)
    {
        $deleteForm = $this->createDeleteForm($address);

        return $this->render('address/show.html.twig', array(
            'address' => $address,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing address entity.
     *
     * @Route("/{id}/edit", name="address_edit")
     * @Method({"GET", "POST"})
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR', 'ROLE_CONFERENCE_OWNER', 'ROLE_CONFERENCE_ADMIN'])")
     */
    public function editAction(Request $request, Address $address)
    {
        $deleteForm = $this->createDeleteForm($address);
        $editForm = $this->createForm('AppBundle\Form\AddressType', $address);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('address_edit', array('id' => $address->getId()));
        }

        return $this->render('address/edit.html.twig', array(
            'address' => $address,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a address entity.
     *
     * @Route("/{id}", name="address_delete")
     * @Method("DELETE")
     * @Security("is_granted(['ROLE_SITE_ADMIN', 'ROLE_SITE_EDITOR'])")
     */
    public function deleteAction(Request $request, Address $address)
    {
        $form = $this->createDeleteForm($address);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $addressService = $this->get(AddressService::class);
            $addressService->delete($address);
        }

        return $this->redirectToRoute('address_index');
    }

    /**
     * Creates a form to delete a address entity.
     *
     * @param Address $address The address entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Address $address)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('address_delete', array('id' => $address->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
