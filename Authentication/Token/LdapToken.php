<?php

namespace OVE\AuthentificationBundle\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

class LdapToken extends AbstractToken
{
    private $providerKey;
        
    public function __construct($username, $providerKey, array $roles= array())
    {
        parent::__construct($roles);

        $this->setuser($username);
        $this->providerKey = $providerKey;

        //Cette méthode est appellée si la connexion aboutie. Le username contient le login et les roles (les proprietes de la class LDAPUser)
        //Si la connexion ne passe pas par le LDAP, cette méthode n'est pas appellée
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Token / LdapToken.php : construct");
        //$log->addWarning("Tony : LdapToken : construct : username=".print_r($username,true));
        //$log->addWarning("Tony : LdapToken : construct : username=".$username->getUserName()." : name=".$username->getName());
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Token / LdapToken.php : getCredentials");

        return null;
    }

    public function getProviderKey()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Token / LdapToken.php : getProviderKey");

        return $this->providerKey;
    }

    public function serialize()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Token / LdapToken.php : serialize");

        return serialize(array(
            $this->providerKey,
            parent::serialize()
        ));
    }

    public function unserialize($str)
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Token / LdapToken.php : unserialize");

        list(
            $this->providerKey,
            $parentStr
        ) = unserialize($str);
        
        parent::unserialize($parentStr);
    }
}
