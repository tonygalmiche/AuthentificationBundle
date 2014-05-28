<?php

namespace OVE\AuthentificationBundle\Provider;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException,
    Symfony\Component\Security\Core\Exception\UsernameNotFoundException,
    Symfony\Component\Security\Core\User\UserInterface,
    Symfony\Component\Security\Core\User\UserProviderInterface;

use OVE\AuthentificationBundle\Manager\LdapManagerUserInterface,
    OVE\AuthentificationBundle\User\LdapUser;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;



/**
 * LDAP User Provider
 *
 * @author Boris Morel
 * @author Juti Noppornpitak <jnopporn@shiroyuki.com>
 */
class LdapUserProvider implements UserProviderInterface
{
    /**
     * @var LdapBundle\Manager\LdapManagerUserInterface
     */
    private $ldapManager;

    /**
     * @var string
     */
    private $bindUsernameBefore;

    /**
     * Constructor
     *
     * @param LdapBundle\Manager\LdapManagerUserInterface $ldapManager
     * @param string $bindUsernameBefore
     */
    //public function __construct(LdapManagerUserInterface $ldapManager, $bindUsernameBefore = false)
    public function __construct($ldapManager, $bindUsernameBefore = false)
    {
        $this->ldapManager = $ldapManager;
        $this->bindUsernameBefore = $bindUsernameBefore;


        //Cette fonction est appelle 3 fois lors de la connexion
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapUserProvider.php : __construct : bindUsernameBefore=$bindUsernameBefore");
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($username)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapUserProvider.php : loadUserByUsername : username=$username");



        // Throw the exception if the username is not provided.
        if (empty($username)) {
            throw new UsernameNotFoundException('The username is not provided.');
        }

        if (true === $this->bindUsernameBefore) {
            $ldapUser = $this->simpleUser($username);
        } else {
            $ldapUser = $this->anonymousSearch($username);
        }

        //Si la fonction précédente fait une exception, le code suivant ne sera pas exécuté (username non trouvé
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapUserProvider.php : loadUserByUsername : $username trouvé");



        
        return $ldapUser;
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapUserProvider.php : refreshUser");


        if (!$user instanceof LdapUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapUserProvider.php : supportsClass");


        return $class === 'OVE\AuthentificationBundle\User\LdapUser';
    }

    private function simpleUser($username)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapUserProvider.php : simpleUser");


        $ldapUser = new LdapUser();
        $ldapUser->setUsername($username);

        return $ldapUser;
    }

    private function anonymousSearch($username)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapUserProvider.php : anonymousSearch 1");


        // Throw the exception if the username is not found.
        if(!$this->ldapManager->exists($username)) {
            throw new UsernameNotFoundException(sprintf('User "%s" not found', $username));
        }

        //Si une exception est trouvé dans la fonction précédente, le code ci-dessous n'est pas exécuté

        $lm = $this->ldapManager
            ->setUsername($username)
            ->doPass();

        $ldapUser = new LdapUser();


        //Cette méthode est appellée 3 fois lors de la connexion et une fois lors de la déconnexion
        //lm contient beacoup d'informations sur l'utilsateur (ex : ces roles) et la confiugration de l'authentification
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapUserProvider : anonymousSearch 2 : $username trouvé");
        //$log->addWarning("Tony : LdapUserProvider : anonymousSearch : lm=".print_r($lm,true));



        $ldapUser
            ->setUsername($lm->getUsername())
            ->setEmail($lm->getEmail())
            ->setRoles($lm->getRoles())
            ->setDn($lm->getDn())
            ->setAttributes($lm->getAttributes())
            ;        


				//Il est possilbe ici de définir les roles, le nom et le mail, mais ce n'est pas forcement l'endroit normal pour le faire
				//$ldapUser->setEmail("tony.galmiche@infosaone.com");
				//$ldapUser->setName("Tony Galmiche de anonymousSearch");
				$ldapUser->setName($lm->getName());
				$ldapUser->setAssociation($lm->getAssociation());

        return $ldapUser;
    }
}
