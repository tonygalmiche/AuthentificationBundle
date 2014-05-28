<?php

namespace OVE\AuthentificationBundle\Manager;

use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

use OVE\AuthentificationBundle\Exception\ConnectionException;
use OVE\AuthentificationBundle\Entity\Association;

class LdapConnection implements LdapConnectionInterface
{
    private $params;
    private $ress;
    private $logger;
    private $association_obj;

    public function __construct(array $params, Logger $logger)
    {

        //Cette fonction est appelle lors du vidage du cache et 3 fois lors de la connexion
        //Le tableau params contient la configuration du serveur LDAP
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapConnection.php : __construct : Les paramètres du LDAP sont connus : Appel de this->connect()");
        //$log->addWarning("Tony : LdapConnection : __construct : params=".print_r($params,true));
        //$log->addWarning("##############################################################");

        $this->params = $params;
        $this->logger = $logger;
        $this->association_obj = $this->getAssociation();




        $this->connect();
    }

    
    public function getAssociation() {
        $choix_association=@$_COOKIE["association"];
        if($choix_association=="") $choix_association=0;
        global $kernel;
        if ( 'AppCache' == get_class($kernel) )	{
          $kernel = $kernel->getKernel();
        }
        
        $em = $kernel->getContainer()->get( 'doctrine.orm.entity_manager' );
        $association = $em->getRepository('OVEAuthentificationBundle:Association')->find($choix_association);

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapConnection.php : __construct : choix_association=$choix_association : association=".print_r($association,true));

        return $association;
    }
    



    public function search(array $params)
    {



        
        $ref = array(
            'base_dn' => '',
            'filter' => '',
        );

        if (count($diff = array_diff_key($ref, $params))) {
            throw new \Exception(sprintf('You must defined %s', print_r($diff, true)));
        }
        $attrs = isset($params['attrs']) ? $params['attrs'] : array();
        


        $this->info(
            sprintf('ldap_search base_dn %s, filter %s',
                print_r($params['base_dn'], true),
                print_r($params['filter'], true)
            ));

        $search = @ldap_search(
            $this->ress,
            $params['base_dn'],
            $params['filter'],
            $attrs
        );

        //Cette fonction est appellée 7 fois lors de la connexion et 2 fois lors de la deconnexion
        //-> Elle interroge donc autant de fois le serveur LDAP, ce qui me parait très curieux....
        //Le tableau entries contient toutes les informations du LDAP de l'utilsateur (son nom et prénom)
        //Si cette méthode retourne false la connexion échoue sinon, elle retourne le contenu du LDAP
        //Si le login est correcte mais pas le mot de passe, cette methode retourne tout de même le contenu du LDAP (2 fois)
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapConnection.php : search : params=".print_r($params,true));






        if ($search) {
            $entries = ldap_get_entries($this->ress, $search);
            @ldap_free_result($this->ress);

						//$log->addWarning("Tony : LdapConnection : search");
						//$log->addWarning("Tony : LdapConnection : search : entries=".print_r($entries,true));
						//$cn=@$entries[0]["cn"][0];
						//$log->addWarning("Tony : LdapConnection : search : cn du ldap=$cn");
						//$log->addWarning("Tony : LdapConnection : search ##############################################################");

            return is_array($entries) ? $entries : false;
        }

        return false;
    }

    public function bind($user_dn, $password='')
    {

        //C'est cette méthode qui verifie le mot de passe. Ell est appellée une fois lors de la connexion
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapConnection.php : bind");
        //$log->addWarning("Tony : LdapConnection : bind : user_dn=$user_dn : password=$password");

        if (empty($user_dn) || ! is_string($user_dn)) {
            throw new ConnectionException("LDAP user's DN (user_dn) must be provided (as a string).");
        }

        // According to the LDAP RFC 4510-4511, the password can be blank.
        return @ldap_bind($this->ress, $user_dn, $password);
    }

    public function getParameters()
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapConnection.php : getParameters : params=".print_r($this->params,true));



        return $this->params;
    }

    
#    public function getHost()
#    {
#        return $this->params['client']['host'];
#    }


#    public function getPort()
#    {
#        return $this->params['client']['port'];
#    }

#    public function getBaseDn($index)
#    {
#        return $this->params[$index]['base_dn'];
#    }

#    public function getFilter($index)
#    {
#        return $this->params[$index]['filter'];
#    }

#    public function getNameAttribute($index)
#    {
#        return $this->params[$index]['name_attribute'];
#    }

#    public function getUserAttribute($index)
#    {
#        return $this->params[$index]['user_attribute'];
#    }
#    

    private function connect()
    {

        //** Récupère la valeur de session pour ne pas executer les requetes LDAP et MySQL sans arrêt *******
        // Ne fonctionne pas => Ce n'est pas grave, car elle ne se connecte pas au LDAP

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapConnection.php : connect : ldap_connect");
        //***************************************************************************************************





				//global $kernel;
				//$em = $kernel->getContainer()->get( 'doctrine.orm.entity_manager' );
				//$association = $em->getRepository('OVEAuthentificationBundle:Association')->find(1);


				//Cette methode initialise la connexion au serveur LDAP
				//Elle est appellée 3 fois lors de la connexion et 4 fois lors de la déconnexion, ce qui est très curieux...
        //Elle est également appellée 2 fois pour chaque page affichée
				//$log = new Logger('tony');
				//$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
				//$log->addWarning("Tony : Manager / LdapConnection.php : connect : host=".$this->params['client']['host']);
				//$choix_association=@$_COOKIE["association"];
				//$log->addWarning("Tony : LdapConnection : connect : ldap_connect : Association=".$association->getName()." : GET=".json_encode($_GET));
				//$log->addWarning("Tony : LdapConnection : connect : params=".json_encode($this->params));



        //$port = isset($this->params['client']['port'])
        //    ? $this->params['client']['port']
        //    : '389';
        $port=389;



        //Cette fonction est appellée souvent, mais elle ne se connecte pas au LDAP
        //$host=$this->params['client']['host'];







        $host="localhost";
        if(is_object($this->association_obj)) $host=$this->association_obj->getLdapServerAdress();



        $ress = @ldap_connect($host, $port);

        //if (isset($this->params['client']['version'])) {
        //    ldap_set_option($ress, LDAP_OPT_PROTOCOL_VERSION, $this->params['client']['version']);
        //}
        ldap_set_option($ress, LDAP_OPT_PROTOCOL_VERSION, 3);

        //if (isset($this->params['client']['referrals_enabled'])) {
        //    ldap_set_option($ress, LDAP_OPT_REFERRALS, $this->params['client']['referrals_enabled']);
        //}
        ldap_set_option($ress, LDAP_OPT_REFERRALS,true);

        //if (isset($this->params['client']['network_timeout'])) {
        //    ldap_set_option($ress, LDAP_OPT_NETWORK_TIMEOUT, $this->params['client']['network_timeout']);
        //}

				//Remarque : Cette partie de code est executé, si le username de connexion au LDAP est indiqué dans la configuration
        /*
        if (isset($this->params['client']['username'])) {
            if (!isset($this->params['client']['password'])) {
                throw new \Exception('You must uncomment password key');
            }
            $bindress = @ldap_bind($ress, $this->params['client']['username'], $this->params['client']['password']);


            if (!$bindress) {
                throw new \Exception('The credentials you have configured are not valid');
            }
        }
        */


        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Manager/LdapConnection.php : connect : ldap_connect : ress=$ress");

        $this->ress = $ress;
        return $this;
    }

    private function info($message)
    {
        if ($this->logger) {
            $this->logger->info($message);
        }
    }

    private function err($message)
    {
        if ($this->logger) {
            $this->logger->err($message);
        }
    }

    /**
     * Escape string for use in LDAP search filter.
     *
     * @link http://www.php.net/manual/de/function.ldap-search.php#90158
     * See RFC2254 for more information.
     * @link http://msdn.microsoft.com/en-us/library/ms675768(VS.85).aspx
     * @link http://www-03.ibm.com/systems/i/software/ldap/underdn.html
     */
    public function escape($str)
    {
        $metaChars = array('*', '(', ')', '\\', chr(0));

        $quotedMetaChars = array();

        foreach ($metaChars as $key => $value) {
            $quotedMetaChars[$key] = '\\'.str_pad(dechex(ord($value)), 2, '0');
        }

        $str = str_replace($metaChars, $quotedMetaChars, $str);

        return ($str);
    }
}
