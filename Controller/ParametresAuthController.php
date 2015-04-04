<?php

namespace OVE\AuthentificationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use OVE\AuthentificationBundle\Entity\parametresauth;
use OVE\AuthentificationBundle\Form\ParametresAuthType;

/**
 * ParametresAuth controller.
 *
 * @Route("/parametresauth")
 */
class ParametresAuthController extends Controller
{

    /**
     * @Route("/", name="parametresauth")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEAuthentificationBundle:parametresauth')->find(1);
        if(count($entity)==0) {
          $entity = new parametresauth();
          $entity->setIntroduction('');
          $em = $this->getDoctrine()->getManager();
          $em->persist($entity);
          $em->flush();
        } 
        //$entities =array();

        $editForm = $this->createEditForm($entity);


        return array(
            'entity' => $entity,
            'form'   => $editForm->createView(),
        );
    }



    /**
     * Edits an existing parametresauth entity.
     *
     * @Route("/update", name="parametresauth_update")
     * @Method("PUT")
     * @Template("AuthentificationBundle:parametresauth:index.html.twig")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OVEAuthentificationBundle:parametresauth')->find(1);

        //if (!$entity) {
        //    throw $this->createNotFoundException('Unable to find trames entity.');
        //}

        if ($entity) {
          $editForm = $this->createEditForm($entity);
          $editForm->handleRequest($request);
          if ($editForm->isValid()) {
              $em->flush();
          }
        }

        return $this->redirect($this->generateUrl('parametresauth'));

        //$deleteForm = $this->createDeleteForm($id);
        //$editForm = $this->createEditForm($entity);
        //$editForm->handleRequest($request);
        /*
        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('parametres'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
        */
    }

    /**
    * Creates a form to edit a parametresauth entity.
    *
    * @param parametresauth $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(parametresauth $entity)
    {
        $form = $this->createForm(new parametresauthType(), $entity, array(
            'action' => $this->generateUrl('parametresauth_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }



}
