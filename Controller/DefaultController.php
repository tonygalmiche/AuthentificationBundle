<?php

namespace OVE\AuthentificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;


use OVE\AuthentificationBundle\Entity\Association;
use OVE\AuthentificationBundle\Form\AssociationType;


//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;



class DefaultController extends Controller
{

    public function indexAction()
    {
        //$webservice=$this->container->getParameter('webservice');
        //echo "token_read=".$webservice["token_read"]."<br>\n";
        //echo $this->container->getParameter('test')."<br>\n";
        //return $this->redirect($this->generateUrl("accueil"));
        return $this->render('OVEAuthentificationBundle:Default:index.html.twig', array());
    }

    public function parametrageAction() {
        return $this->render('OVEAuthentificationBundle:Default:parametrage.html.twig', array());
    }

    public function administrationAction() {
        return $this->render('OVEAuthentificationBundle:Default:administration.html.twig', array());
    }






    public function loginAction()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Controller / DefaultController.php : loginAction");


        $error = $this->getAuthenticationError();


				//$log = new Logger('tony');
				//$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
				//$log->addWarning("Tony : DefaultController : loginAction");



				//**** Liste des associations *****************************************
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('OVEAuthentificationBundle:Association')->findAll();
				$associations = array();
				foreach ($entities as $val) {
					$associations[$val->getId()]=$val->getName();
				}
				//*********************************************************************


				$choix_association=@$_COOKIE["association"];
        return $this->render('OVEAuthentificationBundle:Default:login.html.twig', array(
            'last_username' => $this->get('request')->getSession()->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
            'token'         => $this->generateToken(),
            'associations'  => $associations,
            'choix_association'  => $choix_association
        ));
    }




    public function forbiddenAction() {
        return $this->render('OVEAuthentificationBundle:Default:forbidden.html.twig', array());
		}



    private function getAuthenticationError()
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Controller / DefaultController.php : getAuthenticationError");



        if ($this->get('request')->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            return $this->get('request')->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->get('request')->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
    }

    private function generateToken()
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Controller / DefaultController.php : generateToken avant");



        $token = $this->get('form.csrf_provider')
                      ->generateCsrfToken('authenticate');


        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Controller / DefaultController.php : generateToken après");



        return $token;
    }


}


