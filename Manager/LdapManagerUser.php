<?php

namespace OVE\AuthentificationBundle\Manager;

use Symfony\Component\Security\Core\Exception\AuthenticationException;

use OVE\AuthentificationBundle\Entity\Association;


use Symfony\Component\DependencyInjection\ContainerInterface as Container;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Symfony\Component\HttpFoundation\Session\Session;


class LdapManagerUser implements LdapManagerUserInterface
{
    private
        $ldapConnection,
        $username,
        $password,
        $params,
        $ldapUser,
        $association_obj
        ;


    public function __construct(LdapConnectionInterface $conn)
    {


        //Cette fonction est appelle 3 fois lors de la connexion
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : __construct : Appel this->setAssociationObj, ");
        //$log->addWarning("Tony : LdapManagerUser - construct : password=".$this->ldapUser["password"]." : GET=".json_encode($_GET));
        //$log->addWarning("Tony : LdapManagerUser : __construct : conn=".json_encode($this->params));




				$this->setAssociationObj();


        $this->ldapConnection = $conn;
        $this->params = $this->ldapConnection->getParameters();





    }





		private function setAssociationObj() {

      //$log = new Logger('tony');
      //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
      //$log->addWarning("Tony : Manager/LdapManagerUser : setAssociationObj : Lecture \$_COOKIE[\"association\"]");



			//** Recherche de l'association *****************************
			$choix_association=@$_COOKIE["association"];
      if($choix_association=="") $choix_association=1;
			if ($choix_association>0) {
				global $kernel;
				if ( 'AppCache' == get_class($kernel) )	{
					$kernel = $kernel->getKernel();
				}
				// Liste des services disponibles = php app/console container:debug | grep doctrine
				$em = $kernel->getContainer()->get( 'doctrine.orm.entity_manager' );
				$association = $em->getRepository('OVEAuthentificationBundle:Association')->find($choix_association);
				$this->association_obj=$association;
			}
			//***********************************************************
		}













    public function exists($username)
    {
        //Cette méthode est appellée 3 fois lors de la connexion et une fois lors de la deconnxion
        //username contient le login de l'utilisateur même si celui-ci n'existe pas
        //A priori, c'est cette méthode qui est appellée en premier pour vérfier la connexion
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : exists : username=$username : Appel de addLdapUser qui fait la vérification dans LDAP ou MySQL");
        return (bool) $this
            ->setUsername($username)
            ->addLdapUser()
            ;
    }

    public function auth()
    {
        //Cette methode est execute si l'utilsateur existe, même si le mot de passe n'est pas bon
        //this->ldapUser contient toutes les informations du LDAP sur l'utilisateur (nom, prénom,..)
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : auth");
        //$cn=@$this->ldapUser["cn"][0];
        //$log->addWarning("Tony : LdapManagerUser : password=".$this->password);



				$rep=false;
				if ($this->association_obj->getType()=="mysql") {
					if (array_key_exists("password",$this->ldapUser)) {
						if ($this->password==$this->ldapUser["password"]) $rep=true;
					}
				}

				if ($this->association_obj->getType()=="ldap") {
          

					$rep=($this->doPass() && $this->ldapConnection->bind($this->ldapUser['dn'], $this->password));
				}
				return $rep;
    }

    public function doPass()
    {

        //Cette methode est executé 4 fois lors de la connexion et une fois lors de la déconnexion
        //Si le login n'est pas trouvé, elle n'est pas executé
        //Si le login est trovué mais que le mot de passe est incoreccte, elle est executé 3 fois
        //$this contient toutes les informations sur l'utilsateur

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager / LdapManagerUser : doPass");
        //$log->addWarning("Tony : Manager/LdapManagerUser : doPass");
        //$log->addWarning("Tony : Manager/LdapManagerUser : doPass : roles=".@print_r($this->ldapUser['roles'],true));

        try {
            $this->addLdapUser();
            $this->addLdapRoles();
        } catch (\InvalidArgumentException $e) {
            //if (false === $this->params['client']['skip_roles']) {
                throw $e;
            //}
        }
        return $this;
    }

    public function getDn()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : getEmail");

        return $this->ldapUser['dn'];
    }

    public function getEmail()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : getEmail");
        return isset($this->ldapUser['mail'][0]) ? $this->ldapUser['mail'][0] : '';
    }


    public function getName()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : getName");
        return isset($this->ldapUser['cn'][0]) ? $this->ldapUser['cn'][0] : '';
    }

    public function getAssociation()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : getAssociation");

        return isset($this->ldapUser['association'][0]) ? $this->ldapUser['association'][0] : 'non trouvée';
    }



    public function getAttributes()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : getAttributes");
        $attributes = array();
        /*
        foreach ($this->params['user']['attributes'] as $attrName) {
            if (isset($this->ldapUser[$attrName][0])) {
                $attributes[$attrName] = $this->ldapUser[$attrName][0];
            }
        }
        */
        return $attributes;
    }

    public function getLdapUser()
    {
        return $this->ldapUser;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getRoles()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : getRoles");
        return $this->ldapUser['roles'];
    }

    public function setUsername($username)
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : setUsername : username=$username");
        if ($username === "*") {
            throw new \InvalidArgumentException("Invalid username given.");
        }
        $this->username = $username;
        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }




    private function addLdapUser()
    {
        if (!$this->username) {
            throw new \InvalidArgumentException('User is not defined, please use setUsername');
        }



        //** Récupère la valeur de session pour ne pas executer les requetes LDAP et MySQL sans arrêt *******
        //** C'est cette fonction qui vérifie l'existance de l'utilisateur
        global $kernel;
        if ( 'AppCache' == get_class($kernel) )	{
          $kernel = $kernel->getKernel();
        }
        $session = $kernel->getContainer()->get('session');
        $ldapUser=$session->get('ldapUser');
        if($ldapUser!="") {
          $this->ldapUser=$ldapUser;
          return $this;
        }
        //***************************************************************************************************
        





        /*
        //** Recherche de l'association *****************************
        $choix_association=@$_COOKIE["association"];
        global $kernel;
        if ( 'AppCache' == get_class($kernel) )	{
	        $kernel = $kernel->getKernel();
        }
        $em = $kernel->getContainer()->get( 'doctrine.orm.entity_manager' );
        $association = $em->getRepository('OVEAuthentificationBundle:Association')->find($choix_association);
        //***********************************************************
        */

        //Recherche si l'utilisateur existe
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : addLdapUser : execute this->ldapConnection->search() ou la requete MySQL");


				//** Connexion mysql **************************************************
				//if ($association->getType()=="mysql") {
        $err=""; $rep="";
				if ($this->association_obj->getType()=="mysql") {


					$entrie=array("dn"=>$this->username);

					$server         = $this->association_obj->getMysqlServerAdress();
					$user           = $this->association_obj->getMysqlUser();
					$password       = $this->association_obj->getMysqlPassword();
					$database       = $this->association_obj->getMysqlDatabase();
					$table          = $this->association_obj->getMysqlUserTable();
					$LoginField     = $this->association_obj->getMysqlLoginField();
					$PasswordField  = $this->association_obj->getMysqlPasswordField();
					$MailField      = $this->association_obj->getMysqlMailField();

					$FirstNameField = $this->association_obj->getMysqlFirstNameField();
					$LastNameField  = $this->association_obj->getMysqlLastNameField();

					$link = @mysql_connect($server, $user, $password);
					if ($link==false) {
						$err="Impossible de se connecter : " . mysql_error();
					} else {
						$db_selected=mysql_select_db($database, $link);
						if (!$db_selected) {
							$err='Impossible de sélectionner la base de données : ' . mysql_error();
						} else {
							$SQL = 'SHOW TABLES FROM '.$database.' LIKE \''.$table.'\'';
							$result = mysql_query($SQL);
							if (mysql_num_rows($result)==0) {
								$err="La table '$table' n'existe pas !";
							} else {
								$SQL = "select * from `$table` where `$LoginField`='".$this->username."' ";
								$result = mysql_query($SQL);
								if ($result===false) {
									$err="$SQL : ".mysql_error();
								} else {
									if (mysql_num_rows($result)==0) {
										$err="Login '".$this->username."' non trouvé dans MySQL";
									} else {
										$row = mysql_fetch_array($result);
										$Prenom = $row[$FirstNameField];
										$Nom    = $row[$LastNameField];
										$rep="$Prenom $Nom";
										$entrie["mail"]     = array($row[$MailField]);
										$entrie["password"] = $row[$PasswordField];

									}
								}
							}
						}
						mysql_close($link);
					}

          if ($err!="") return false;

					$entrie["association"] = array($this->association_obj->getName());
					$entrie["cn"]          = array($rep);
					$this->ldapUser=$entrie;



				}
				//*********************************************************************


				//$log = new Logger('tony');
				//$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
				//$log->addWarning("Tony : Manager / LdapManagerUser : addLdapUser : err=$err");




				//** Connexion LDAP ***************************************************
				//if ($association->getType()=="ldap") {
				if ($this->association_obj->getType()=="ldap") {

					//$filter = isset($this->params['user']['filter'])
					//		? $this->params['user']['filter']
					//		: '';

          //$base_dn=$this->params['user']['base_dn'];

          $filter="";
          $base_dn=$this->association_obj->getLdapDn();
          $name_attribute="uid";
					$entries = $this->ldapConnection
							->search(array(
									'base_dn' => $base_dn,
									'filter' => sprintf('(&%s(%s=%s))',
																			$filter,
																			$name_attribute,
																			$this->ldapConnection->escape($this->username)
									)
							));

					if ($entries['count'] > 1) {
							throw new \RuntimeException("This search can only return a single user");
					}

					if ($entries['count'] == 0) {
							return false;
					}

					$entries[0]["association"]=array($this->association_obj->getName());
					$this->ldapUser = $entries[0];
				}
				//*********************************************************************





        $session->set('ldapUser', $this->ldapUser);

        return $this;
    }

    private function addLdapRoles()
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : addLdapRoles : recherche rôles dans session");



        //** Récupère la valeur de session pour ne pas executer les requetes MySQL et Gestetab sans arrêt ***
        //** C'est cette fonction qui vérifie l'existance de l'utilisateur
        //** ATTENTION : Avec la mise en place des établissements, il faudra bien mettre à jour le rôle du directeur si l'établissement change
        global $kernel;
        if ( 'AppCache' == get_class($kernel) )	{
          $kernel = $kernel->getKernel();
        }
        $session = $kernel->getContainer()->get('session');
        $roles=$session->get('roles');
        //if($roles!="") {
        //  $this->ldapUser['roles'] = $roles;
        //  return $this;
        //}
        //***************************************************************************************************
        


        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : addLdapRoles : recherche rôles car pas dans session");



        if (null === $this->ldapUser) {
            throw new \RuntimeException('Cannot assign LDAP roles before authenticating user against LDAP');
        }



				//** Recherche de l'utilisateur à partir de son login et association ************
				$roles=array("ROLE_USER"=>"ROLE_USER");
				$login = $this->username;
				$id_association = $this->association_obj->getId();

				if ($id_association>0 and $login<>"") {
					global $kernel;
					if ( 'AppCache' == get_class($kernel) )	{
						$kernel = $kernel->getKernel();
					}
					$em = $kernel->getContainer()->get( 'doctrine.orm.entity_manager' );
					$repository  = $em->getRepository('OVEAuthentificationBundle:utilisateur');
					$utilisateur = $repository->findOneBy(array('login' => $login, 'id_association' => $id_association));
					if (is_object($utilisateur)) {
						$id_utilisateur=$utilisateur->getId();
						$getRoles=$utilisateur->getRoles();
						foreach($getRoles as $role) {  
							$r=$role->getRole();
							$roles[$r]=$r;
						}
					}
				}


        //** Ajout du role de directeur *************************************************
        //if($this->params["gestetab"]["getDirecteur"]) {
        $etablissement_id=@$_COOKIE["etablissement"];
        //$etablissement_id=101021; //OVE - DELTA 01
        if ($etablissement_id>0) {
          $directeur=$this->get_directeur($etablissement_id);
          if($login==$directeur) $roles["ROLE_DIRECTEUR"]="ROLE_DIRECTEUR"; 
          //$log = new Logger('tony');
          //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
          //$log->addWarning("Tony : Manager/LdapManagerUser : addLdapRoles : directeur=$directeur");
        }
        //}
        //*******************************************************************************


        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : addLdapRoles : roles=".print_r($roles,true));


        $this->ldapUser['roles'] = $roles;
        $session->set('roles', $roles);
        return $this;
    }




 
    function get_directeur($gid) {

      //** Lecture des paramètres du fichier parameters.yml *********
      global $kernel;
      $container=$kernel->getContainer();
      $gestetab=$container->getParameter('gestetab');
      $host          = $gestetab["host"];
      $user          = $gestetab["user"];
      $password      = $gestetab["password"];
      $get_directeur = $gestetab["get_directeur"];
      //*************************************************************

      if($get_directeur==false) return "";

      $REQ=array();
      //$REQ["reqLogin"]     = $this->params["gestetab"]["reqLogin"];
      //$REQ["reqPwd"]       = $this->params["gestetab"]["reqPwd"];
      $REQ["reqLogin"]     = $user;
      $REQ["reqPwd"]       = $password;

      $REQ["reqMethod"]    = 'etabInfo';
      $REQ["reqIdent"]     = $gid;
      $REQ["reqItem"]      = 'gacDirLogin';
      $REQ["reqFiltre"]    = '' ;
      $REQ["reqTri"]       =  '' ;
      $jsoREQ = json_encode($REQ) ;


      //$host=$this->params["gestetab"]["host"];
      $url = "http://$host/index.php";       
      $url .= "?reqAction=WBS&REQ=". rawurlencode ( $jsoREQ );
      $reqResult = file_get_contents( $url );

      //$log = new Logger('tony');
      //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
      //$log->addWarning("Tony : Manager/LdapManagerUser : get_directeur : reqLogin=".$this->params["gestetab"]["reqLogin"]);
      //$log->addWarning("Tony : Manager/LdapManagerUser : get_directeur : gestetab_host=".$gestetab["host"]);
      //$log->addWarning("Tony : Manager/LdapManagerUser : get_directeur : gestetab_host=".print_r($container->getParameter('gestetab'),true));
      //$log->addWarning("Tony : Manager/LdapManagerUser : get_directeur : url=$url");





      $etab = json_decode ( rawurldecode($reqResult));
      if (!is_object($etab)) return; 
        if ($etab->error) {
            return;
        }
      $etab_detail=$etab->value;
      return $etab_detail[0]->gacDirLogin;
    }
  







    private static function slugify($role)
    {
        $role = preg_replace('/\W+/', '_', $role);
        $role = trim($role, '_');
        $role = strtoupper($role);

        return $role;
    }

    private function getUserId()
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapManagerUser : getUserId");

        //switch ($this->params['role']['user_id']) {
        $user_id="dn";
        switch ($user_id) {
            case 'dn':
                return $this->ldapUser['dn'];
                break;

            case 'username':
                return $this->username;
                break;

            default:
                throw new \Exception(sprintf("The value can't be retrieved for this user_id : %s",$this->params['role']['user_id']));
        }
    }
}
