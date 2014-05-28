<?php

namespace OVE\AuthentificationBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\ExecutionContext;

/**
 * Association
 *
 * @ORM\Table(name="association")
 * @ORM\Entity()
 * @Assert\Callback(methods={"validateFields"}) 
 */
class Association
{


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @Assert\NotBlank(message="Veuillez renseigner les champs obligatoires")
     * @Assert\Length(max=30, maxMessage="Le nombre maximal de cractères autorisés pour ce champ est 100")
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z]/",
     *     message="Veuillez entrer une valeur valide pour le champ suivant"
     * )
     * 
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @var string
     * @Assert\Choice(choices = {"ldap", "mysql" , "google" }, message="Veuillez entrer une valeur valide pour le champ suivant")
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var string
     * @Assert\Length(max=100, maxMessage="Le nombre maximal de cractères autorisés pour ce champ est 100")
     * 
     * @ORM\Column(name="ldap_server_adress", type="string",nullable=true, length=100)
     */
    private $ldapServerAdress;

    /**
     * @var integer
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="Veuillez entrer une valeur valide pour le champ suivant"
     * )
     * @ORM\Column(name="ldap_port", type="integer",nullable=true)
     */
    private $ldapPort;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="ldap_dn", type="string", length=50,nullable=true)
     */
    private $ldapDn;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="ldap_password", type="string", length=50,nullable=true)
     */
    private $ldapPassword;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="ldap_db_root", type="string", length=50,nullable=true)
     */
    private $ldapDbRoot;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="ldap_filter", type="string", length=50,nullable=true)
     */
    private $ldapFilter;

    /**
     * @var string 
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_server_adress", type="string", length=50,nullable=true)
     */
    private $mysqlServerAdress;

    /**
     * @var integer
     * @Assert\Regex(
     *     pattern="/^[0-9]*$/",
     *     message="Veuillez entrer une valeur valide pour le champ suivant"
     * )
     * @ORM\Column(name="mysql_port", type="integer",nullable=true)
     */
    private $mysqlPort;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_user", type="string", length=50,nullable=true)
     */
    private $mysqlUser;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_password", type="string", length=50,nullable=true)
     */
    private $mysqlPassword;


    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_database", type="string", length=50,nullable=true)
     */
    private $mysqlDatabase;




    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_user_table", type="string", length=50,nullable=true)
     */
    private $mysqlUserTable;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_login_field", type="string", length=50,nullable=true)
     */
    private $mysqlLoginField;

    /**
     * @var string
     * @Assert\Length(max=100, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 100")
     * @ORM\Column(name="mysql_mail_field", type="string", length=100,nullable=true)
     */
    private $mysqlMailField;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_password_field", type="string", length=50,nullable=true)
     */
    private $mysqlPasswordField;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_first_name_field", type="string", length=50,nullable=true)
     */
    private $mysqlFirstNameField;

    /**
     * @var string
     * @Assert\Length(max=50, maxMessage="Le nombre maximal de caractères autorisés pour ce champ est 50")
     * @ORM\Column(name="mysql_last_name_field", type="string", length=50,nullable=true)
     */
    private $mysqlLastNameField;


    public function validateFields(ExecutionContext $context)
    {       


      if($this->type === 'mysql') {



				$server         = $this->getMysqlServerAdress();
				$user           = $this->getMysqlUser();
				$password       = $this->getMysqlPassword();
				$database       = $this->getMysqlDatabase();
				//$database       = "gestactiv";
				$table          = $this->getMysqlUserTable();
				$LoginField     = $this->getMysqlLoginField();
				$PasswordField  = $this->getMysqlPasswordField();
				$MailField      = $this->getMysqlMailField();

				$FirstNameField = $this->getMysqlFirstNameField();
				$LastNameField  = $this->getMysqlLastNameField();

				$rep=true;
				$link = @mysql_connect($server, $user, $password);
				if ($link==false) {
					$rep="Impossible de se connecter : " . mysql_error();
				} else {
					$db_selected=mysql_select_db($database, $link);
					if (!$db_selected) {
						$rep='Impossible de sélectionner la base de données : ' . mysql_error();
					} else {
						$SQL = 'SHOW TABLES FROM '.$database.' LIKE \''.$table.'\'';
						$result = mysql_query($SQL);
						if (mysql_num_rows($result)==0) {
							$rep="La table '$table' n'existe pas !";
						} else {
							$result = mysql_query("SHOW COLUMNS FROM `$table`");
							if (mysql_num_rows($result) > 0) {
								$champs=array();
								while ($row = mysql_fetch_assoc($result)) {
									$champs[]=$row["Field"];
								}
								if (!in_array($LoginField,$champs))     $rep="Le champ '$LoginField' n'existe pas dans la table '$table' !";
								if (!in_array($PasswordField,$champs))  $rep="Le champ '$PasswordField' n'existe pas dans la table '$table' !";
								if (!in_array($MailField,$champs))      $rep="Le champ '$MailField' n'existe pas dans la table '$table' !";
								if (!in_array($FirstNameField,$champs) and $FirstNameField!="") $rep="Le champ '$FirstNameField' n'existe pas dans la table '$table' !";
								if (!in_array($LastNameField,$champs)  and $LastNameField!="")  $rep="Le champ '$LastNameField' n'existe pas dans la table '$table' !".print_r($champs,true);
								}
							}
						}
						mysql_close($link);
					}
					if($rep!==true) $context->addViolationAt("mysqlServerAdress", $rep, array(), null);
				}

				



 
       $message=  'Veuillez renseigner les champs obligatoires';
       $empty_field_found=false;
        if($this->type === 'ldap' )
        {
         //$ldapFields = array('ldapServerAdress' => 'adresse du serveur LDAP','ldapPort'=> 'Port de serveur LDAP' ,'ldapDn' => 'dn de serveur LDAP','ldapPassword' => 'Mot de passe de serveur LDAP','ldapDbRoot' => 'Administrateur serveur ldap','ldapFilter'=> 'Filtre serveur ldap');
      

         $ldapFields = array('ldapServerAdress' => 'adresse du serveur LDAP','ldapDn' => 'dn de serveur LDAP');




           foreach( $ldapFields as $k => $v)
             {
              if(property_exists($this, $k))
                {
                    if(is_null($this->{$k}))
                    {
                        //Info: addViolationAtSubPath() is deprecated since version 2.2 and will be removed in 2.3.
                        //$context->addViolationAtSubPath($k, sprintf('Le champ %s est obligatoire', $v), array(), null);
                        $context->addViolationAt($k, sprintf('Le champ %s est obligatoire', $v), array(), null);
                    }                 
                }           
            
            }
          }
          elseif($this->type === 'mysql' )
        {
         $mysqlFields = array('mysqlServerAdress' => 'adresse du serveur MYSQL','mysqlUser'=> 'Nom utilisateur MYSQL','mysqlPassword'=> 'Mot de passe MYSQL','mysqlUserTable'=> 'table utilisateur de MYSQL','mysqlDatabase'=> 'Base de données de MySQL','mysqlLoginField'=> 'champ login de  mysql','mysqlPasswordField'=> 'champ password de  mysql','mysqlMailField'=> 'champ mail de  mysql');       
           foreach( $mysqlFields as $k => $v)
             {
              if(property_exists($this, $k))
                {
                    if(is_null($this->{$k}))
                    {
                        $context->addViolationAt($k, sprintf('Le champ %s est obligatoire', $v), array(), null);
                    }  
                }                       
            }
          }
          
            
       if($empty_field_found)
       {
         $context->setPropertyPath($propertyPath);
         $context->addViolation($message, array(), null);           
       }
        
         
    }   
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Association
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Association
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set ldapServerAdress
     *
     * @param string $ldapServerAdress
     * @return Association
     */
    public function setLdapServerAdress($ldapServerAdress)
    {
        $this->ldapServerAdress = $ldapServerAdress;
    
        return $this;
    }

    /**
     * Get ldapServerAdress
     *
     * @return string 
     */
    public function getLdapServerAdress()
    {
        return $this->ldapServerAdress;
    }

    /**
     * Set ldapPort
     *
     * @param integer $ldapPort
     * @return Association
     */
    public function setLdapPort($ldapPort)
    {
        $this->ldapPort = $ldapPort;
    
        return $this;
    }

    /**
     * Get ldapPort
     *
     * @return integer 
     */
    public function getLdapPort()
    {
        return $this->ldapPort;
    }

    /**
     * Set ldapDn
     *
     * @param string $ldapDn
     * @return Association
     */
    public function setLdapDn($ldapDn)
    {
        $this->ldapDn = $ldapDn;
    
        return $this;
    }

    /**
     * Get ldapDn
     *
     * @return string 
     */
    public function getLdapDn()
    {
        return $this->ldapDn;
    }

    /**
     * Set ldapPassword
     *
     * @param string $ldapPassword
     * @return Association
     */
    public function setLdapPassword($ldapPassword)
    {
        $this->ldapPassword = $ldapPassword;
    
        return $this;
    }

    /**
     * Get ldapPassword
     *
     * @return string 
     */
    public function getLdapPassword()
    {
        return $this->ldapPassword;
    }

    /**
     * Set ldapDbRoot
     *
     * @param string $ldapDbRoot
     * @return Association
     */
    public function setLdapDbRoot($ldapDbRoot)
    {
        $this->ldapDbRoot = $ldapDbRoot;
    
        return $this;
    }

    /**
     * Get ldapDbRoot
     *
     * @return string 
     */
    public function getLdapDbRoot()
    {
        return $this->ldapDbRoot;
    }

    /**
     * Set ldapFilter
     *
     * @param string $ldapFilter
     * @return Association
     */
    public function setLdapFilter($ldapFilter)
    {
        $this->ldapFilter = $ldapFilter;
    
        return $this;
    }

    /**
     * Get ldapFilter
     *
     * @return string 
     */
    public function getLdapFilter()
    {
        return $this->ldapFilter;
    }

    /**
     * Set mysqlServerAdress
     *
     * @param string $mysqlServerAdress
     * @return Association
     */
    public function setMysqlServerAdress($mysqlServerAdress)
    {
        $this->mysqlServerAdress = $mysqlServerAdress;
    
        return $this;
    }

    /**
     * Get mysqlServerAdress
     *
     * @return string 
     */
    public function getMysqlServerAdress()
    {
        return $this->mysqlServerAdress;
    }

    /**
     * Set mysqlPort
     *
     * @param integer $mysqlPort
     * @return Association
     */
    public function setMysqlPort($mysqlPort)
    {
        $this->mysqlPort = $mysqlPort;
    
        return $this;
    }

    /**
     * Get mysqlPort
     *
     * @return integer 
     */
    public function getMysqlPort()
    {
        return $this->mysqlPort;
    }

    /**
     * Set mysqlUser
     *
     * @param string $mysqlUser
     * @return Association
     */
    public function setMysqlUser($mysqlUser)
    {
        $this->mysqlUser = $mysqlUser;
    
        return $this;
    }

    /**
     * Get mysqlUser
     *
     * @return string 
     */
    public function getMysqlUser()
    {
        return $this->mysqlUser;
    }

    /**
     * Set mysqlPassword
     *
     * @param string $mysqlPassword
     * @return Association
     */
    public function setMysqlPassword($mysqlPassword)
    {
        $this->mysqlPassword = $mysqlPassword;
    
        return $this;
    }

    /**
     * Get mysqlPassword
     *
     * @return string 
     */
    public function getMysqlPassword()
    {
        return $this->mysqlPassword;
    }




    /**
     * Set mysqlDatabase
     *
     * @param string $mysqlDatabase
     * @return string
     */
    public function setMysqlDatabase($mysqlDatabase)
    {
        $this->mysqlDatabase = $mysqlDatabase;
        return $this;
    }

    /**
     * Get mysqlDatabase
     *
     * @return string 
     */
    public function getMysqlDatabase()
    {
        return $this->mysqlDatabase;
    }








    /**
     * Set mysqlUserTable
     *
     * @param string $mysqlUserTable
     * @return Association
     */
    public function setMysqlUserTable($mysqlUserTable)
    {
        $this->mysqlUserTable = $mysqlUserTable;
    
        return $this;
    }

    /**
     * Get mysqlUserTable
     *
     * @return string 
     */
    public function getMysqlUserTable()
    {
        return $this->mysqlUserTable;
    }




    /**
     * Set mysqlLoginField
     *
     * @param string $mysqlLoginField
     * @return Association
     */
    public function setMysqlLoginField($mysqlLoginField)
    {
        $this->mysqlLoginField = $mysqlLoginField;
    
        return $this;
    }

    /**
     * Get mysqlLoginField
     *
     * @return string 
     */
    public function getMysqlLoginField()
    {
        return $this->mysqlLoginField;
    }

    /**
     * Set mysqlPasswordField
     *
     * @param string $mysqlPasswordField
     * @return Association
     */
    public function setMysqlPasswordField($mysqlPasswordField)
    {
        $this->mysqlPasswordField = $mysqlPasswordField;
    
        return $this;
    }

    /**
     * Get mysqlPasswordField
     *
     * @return string 
     */
    public function getMysqlPasswordField()
    {
        return $this->mysqlPasswordField;
    }






   /**
     * Set mysqlMailField
     *
     * @param string mysqlMailField
     * @return string
     */
    public function setMysqlMailField($mysqlMailField)
    {
        $this->mysqlMailField = $mysqlMailField;
        return $this;
    }

    /**
     * Get mysqlMailField
     *
     * @return string 
     */
    public function getMysqlMailField()
    {
        return $this->mysqlMailField;
    }








    /**
     * Set mysqlFirstNameField
     *
     * @param string $mysqlFirstNameField
     * @return Association
     */
    public function setMysqlFirstNameField($mysqlFirstNameField)
    {
        $this->mysqlFirstNameField = $mysqlFirstNameField;
    
        return $this;
    }

    /**
     * Get mysqlFirstNameField
     *
     * @return string 
     */
    public function getMysqlFirstNameField()
    {
        return $this->mysqlFirstNameField;
    }

    /**
     * Set mysqlLastNameField
     *
     * @param string $mysqlLastNameField
     * @return Association
     */
    public function setMysqlLastNameField($mysqlLastNameField)
    {
        $this->mysqlLastNameField = $mysqlLastNameField;
    
        return $this;
    }

    /**
     * Get mysqlLastNameField
     *
     * @return string 
     */
    public function getMysqlLastNameField()
    {
        return $this->mysqlLastNameField;
    }


		public function __construct()
		{
				//Valeurs par defaut lors de la creation de l'objet
				$this->ldapServerAdress    = 'localhost';
				$this->ldapPort            = '389';
				$this->mysqlServerAdress   = 'localhost';
				$this->mysqlPort           = '3306';
				$this->mysqlUserTable      = 'users';
				$this->mysqlLoginField     = 'login';
				$this->mysqlPasswordField  = 'password';
				$this->mysqlFirstNameField = 'first_name';
				$this->mysqlLastNameField  = 'last_name';
		}

}
