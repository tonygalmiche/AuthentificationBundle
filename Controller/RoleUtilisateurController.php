<?php

namespace OVE\AuthentificationBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use \Symfony\Component\HttpFoundation\Response;

use OVE\AuthentificationBundle\Entity\utilisateur;
use OVE\AuthentificationBundle\Form\utilisateurType;

use OVE\AuthentificationBundle\Entity\role;
use OVE\AuthentificationBundle\Form\roleType;




/**
 * @Route("/")
 */
class RoleUtilisateurController extends Controller
{

    /**
     * @Route("/role-utilisateur", name="role-utilisateur")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();


				$utilisateurs = $em->getRepository('OVEAuthentificationBundle:utilisateur')->findAll();
				$roles        = $em->getRepository('OVEAuthentificationBundle:role')->findAll();


        $RoleUtilisateur = array();
        foreach($utilisateurs as $utilisateur) {  
					$getRoles=$utilisateur->getRoles();
					foreach($roles as $role) {  	
            if ($getRoles->contains($role)) $r=1; else $r=0;
						//echo "$r<br>\n";
						$RoleUtilisateur[$utilisateur->getId()][$role->getId()] = $r;
					}
        }
				//print_r($RoleUtilisateur);


				/*
        $RoleUtilisateurData = array();
        foreach($utilisateurs as $utilisateur) {
					$roles = $utilisateur->getRoles();
					echo $utilisateur->getLogin()."<br>\n";
          foreach($roles as $role) {
						echo "->".$role->getRole()."<br>\n";
					}
				}
				*/
					/*
            $line = array('action' => $utilisateur->getLogin());
            foreach($roles as $role)
            {
                $queryBuilder = $em->getRepository('AcmeNoAjaxBundle:RoleAction')->createQueryBuilder('ra') 
                                           ->select('COUNT(ra.id)') 
                                           ->where('ra.role = :role_id AND ra.action = :action_id')
                                           ->setParameters(array('role_id' => $role->getId(), 'action_id' => $action->getId())); 
                $roleActionCount = $queryBuilder->getQuery()->getSingleScalarResult();

                $line[$action->getId().'-'.$role->getId()] = ($roleActionCount > 0)?1:0;
            }
            $roleActionData[] = $line;
        */

				return $this->render('OVEAuthentificationBundle:RoleUtilisateur:index.html.twig', 
						array(	'roles'           => $roles,
										'utilisateurs'    => $utilisateurs,
										'RoleUtilisateur' => $RoleUtilisateur)
						);


        //return new Response("success ");


		}


    /**
     * @Route("/role-utilisateur-update", name="role-utilisateur-update")
     * @Method("GET")
     * @Template()
     */
    public function role_utilisateur_updateAction() {

			$id_utilisateur = $this->getRequest()->query->get('id_utilisateur');
			$id_role        = $this->getRequest()->query->get('id_role');
			$action         = $this->getRequest()->query->get('action');

			$em = $this->getDoctrine()->getEntityManager();

			$utilisateur = $em->getRepository('OVEAuthentificationBundle:utilisateur')->find($id_utilisateur);
			$role        = $em->getRepository('OVEAuthentificationBundle:role')->find($id_role);

			
			if ($action=="add") {
				$role->addUtilisateur($utilisateur);
			} else {
				$role->removeUtilisateur($utilisateur);
			}
			$em->persist($role);
			
			/*
			// ATTENTION : Ne fonctionne pas dans ce sens
			if ($action=="add") {
				$utilisateur->addRole($role);
			} else {
				$utilisateur->removeRole($role);
			}
			$em->persist($utilisateur);
			*/

			$em->flush();


      //return new Response("id_utilisateur=$id_utilisateur : id_role=$id_role : action=$action");
      return new Response("");
		}
}
