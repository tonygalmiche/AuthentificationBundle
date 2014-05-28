<?php

namespace OVE\AuthentificationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use OVE\AuthentificationBundle\Entity\role;
use OVE\AuthentificationBundle\Form\roleType;

/**
 * role controller.
 *
 * @Route("/role")
 */
class roleController extends Controller
{
    /**
     * Lists all role entities.
     *
     * @Route("/", name="role")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OVEAuthentificationBundle:role')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new role entity.
     *
     * @Route("/", name="role_create")
     * @Method("POST")
     * @Template("OVEAuthentificationBundle:role:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new role();
        $form = $this->createForm(new roleType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('role', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new role entity.
     *
     * @Route("/new", name="role_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new role();
        $form   = $this->createForm(new roleType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Finds and displays a role entity.
     *
     * @Route("/{id}", name="role_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEAuthentificationBundle:role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find role entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing role entity.
     *
     * @Route("/{id}/edit", name="role_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEAuthentificationBundle:role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find role entity.');
        }

        $editForm = $this->createForm(new roleType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing role entity.
     *
     * @Route("/{id}", name="role_update")
     * @Method("PUT")
     * @Template("OVEAuthentificationBundle:role:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEAuthentificationBundle:role')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find role entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new roleType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('role', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a role entity.
     *
     * @Route("/{id}/delete", name="role_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        //$form = $this->createDeleteForm($id);
        //$form->bind($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OVEAuthentificationBundle:role')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find role entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('role'));
    }

    /**
     * Creates a form to delete a role entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
