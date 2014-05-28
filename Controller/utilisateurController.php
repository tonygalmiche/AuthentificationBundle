<?php

namespace OVE\AuthentificationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use OVE\AuthentificationBundle\Entity\utilisateur;
use OVE\AuthentificationBundle\Form\utilisateurType;

/**
 * utilisateur controller.
 *
 * @Route("/utilisateur")
 */
class utilisateurController extends Controller
{
    /**
     * Lists all utilisateur entities.
     *
     * @Route("/", name="utilisateur")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OVEAuthentificationBundle:utilisateur')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new utilisateur entity.
     *
     * @Route("/", name="utilisateur_create")
     * @Method("POST")
     * @Template("OVEAuthentificationBundle:utilisateur:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new utilisateur();
        $form = $this->createForm(new utilisateurType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('utilisateur', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new utilisateur entity.
     *
     * @Route("/new", name="utilisateur_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new utilisateur();
        $form   = $this->createForm(new utilisateurType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a utilisateur entity.
     *
     * @Route("/{id}", name="utilisateur_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEAuthentificationBundle:utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find utilisateur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing utilisateur entity.
     *
     * @Route("/{id}/edit", name="utilisateur_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEAuthentificationBundle:utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find utilisateur entity.');
        }

        $editForm = $this->createForm(new utilisateurType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing utilisateur entity.
     *
     * @Route("/{id}", name="utilisateur_update")
     * @Method("PUT")
     * @Template("OVEAuthentificationBundle:utilisateur:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEAuthentificationBundle:utilisateur')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find utilisateur entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new utilisateurType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('utilisateur', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a utilisateur entity.
     *
     * @Route("/{id}/delete", name="utilisateur_delete")
     * @Method("GET")
     */
    public function deleteAction(Request $request, $id)
    {
        //$form = $this->createDeleteForm($id);
        //$form->bind($request);

        //if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OVEAuthentificationBundle:utilisateur')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find utilisateur entity.');
            }

            $em->remove($entity);
            $em->flush();
        //}

        return $this->redirect($this->generateUrl('utilisateur'));
    }

    /**
     * Creates a form to delete a utilisateur entity by id.
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
