<?php

namespace OVE\AuthentificationBundle\Event;

use Symfony\Component\EventDispatcher\Event;

use OVE\AuthentificationBundle\User\LdapUser;


//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

class LdapUserEvent extends Event
{ 
    private $user;

    public function __construct(LdapUser $user)
    {
        $this->user = $user;

        //Cette methode est appellée une fois lors de la connexion uniqument si le login est connu même si le mot de passe n'est pas bon
        //L'objet user contien le login et les roles même si le mot de passe n'est pas correcte
        //Si le login est inconnu, cette méthode n'est pas appellée
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Event/LdapUserEvent.php : __construct : UserName=".$user->getUserName()." : name=".$user->getName());
        //$log->addWarning("Tony : LdapUserEvent : __construct : user=".print_r($user,true));


    }

    public function getUser()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Event/LdapUserEvent.php : getUser");

        return $this->user;
    }
}
