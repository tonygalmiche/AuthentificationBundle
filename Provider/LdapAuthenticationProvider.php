<?php

namespace OVE\AuthentificationBundle\Provider;

use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use OVE\AuthentificationBundle\Authentication\Token\LdapToken;
use OVE\AuthentificationBundle\Manager\LdapManagerUserInterface;
use OVE\AuthentificationBundle\Event\LdapUserEvent;
use OVE\AuthentificationBundle\Event\LdapEvents;
use OVE\AuthentificationBundle\User\LdapUser;


//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;


class LdapAuthenticationProvider implements AuthenticationProviderInterface
{
    private
        $userProvider,
        $ldapManager,
        $dispatcher,
        $providerKey,
        $hideUserNotFoundExceptions,
        $msg_error
        ;

    /**
     * Constructor
     *
     * Please note that $hideUserNotFoundExceptions is true by default in order
     * to prevent a possible brute-force attack.
     *
     * @param UserProviderInterface    $userProvider
     * @param LdapManagerUserInterface $ldapManager
     * @param EventDispatcherInterface $dispatcher
     * @param string                   $providerKey
     * @param Boolean                  $hideUserNotFoundExceptions
     */


//        LdapManagerUserInterface $ldapManager,

    public function __construct(
        UserProviderInterface $userProvider,
        AuthenticationProviderInterface $daoAuthenticationProvider,
        $ldapManager,
        EventDispatcherInterface $dispatcher = null,
        $providerKey,
        $hideUserNotFoundExceptions = true
    )
    {


        //Cette fonction est appelle 3 fois lors de la connexion
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapAuthenticationProvider.php : __construct : providerKey = $providerKey");



        $this->userProvider = $userProvider;
        $this->daoAuthenticationProvider = $daoAuthenticationProvider;
        $this->ldapManager = $ldapManager;
        $this->dispatcher = $dispatcher;
        $this->providerKey = $providerKey;
        $this->hideUserNotFoundExceptions = $hideUserNotFoundExceptions;

        $this->msg_error="Utilisateur ou mot de passe erroné !";

    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(TokenInterface $token)
    {


        //Cette fonction est appellée 1 fois lors de la connexion que le login ou le mot de passe soit correcte ou pas
        //Elle n'est pas appellée lors de la deconexion
        //Le token contient le login saisie par l'utiliasteur
        //-> token=UsernamePasswordToken(user="prod11t", authenticated=false, roles="")
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapAuthenticationProvider.php : authenticate : token=".$token);
        //$log->addWarning("Tony : LdapAuthenticationProvider : authenticate : token->getUsername()=".$token->getUsername());





        if (!$this->supports($token)) {
            throw new AuthenticationException('Unsupported token');
        }

        try {
            $user = $this->userProvider
                ->loadUserByUsername($token->getUsername());
        } catch (UsernameNotFoundException $userNotFoundException) {
            if ($this->hideUserNotFoundExceptions) {
                //throw new BadCredentialsException('Bad credentials 1', 0, $userNotFoundException);
                throw new BadCredentialsException($this->msg_error, 0, $userNotFoundException);
            }

            throw $userNotFoundException;
        }

        if ($user instanceof LdapUser) {
            if (null !== $this->dispatcher) {
                $userEvent = new LdapUserEvent($user);
                try {
                    $this->dispatcher->dispatch(LdapEvents::PRE_BIND, $userEvent);
                } catch (\Exception $expt) {
                    if ($this->hideUserNotFoundExceptions) {
                        throw new BadCredentialsException('Bad credentials 2', 0, $expt);
                    }

                    throw $expt;
                }
            }

            if ($this->bind($user, $token)) {
                if (false === $user->getDn()) {
                    $user = $this->reloadUser($user);
                }


                //$log = new Logger('tony');
                //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
                //$log->addWarning("Tony : Provider/LdapAuthenticationProvider.php : authenticate : getRoles=".print_r($user->getRoles(),true));




                $ldapToken = new LdapToken($user, $this->providerKey, $user->getRoles());
                $ldapToken->setAuthenticated(true);
                $ldapToken->setAttributes($token->getAttributes());

                return $ldapToken;
            }

            if ($this->hideUserNotFoundExceptions) {
                //throw new BadCredentialsException('Bad credentials 3');
                throw new BadCredentialsException($this->msg_error);



            } else {
                throw new AuthenticationException('The LDAP authentication failed.');
            }
        }

        if ($user instanceof UserInterface) {
            return $this->daoAuthenticationProvider->authenticate($token);
        }
    }

    /**
     * Authenticate the user with LDAP bind.
     *
     * @param LdapBundle\User\LdapUser  $user
     * @param TokenInterface $token
     *
     * @return boolean
     */
    private function bind(LdapUser $user, TokenInterface $token)
    {


        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapAuthenticationProvider : bind");



        $this->ldapManager
            ->setUsername($user->getUsername())
            ->setPassword($token->getCredentials());

        return (bool)$this->ldapManager->auth();
    }

    /**
     * Reload user with the username
     *
     * @param LdapBundle\User\LdapUser $user
     * @return LdapBundle\User\LdapUser $user
     */
    private function reloadUser(LdapUser $user)
    {


        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapAuthenticationProvider : reloadUser");


        try {
            $user = $this->userProvider->refreshUser($user);
        } catch (UsernameNotFoundException $userNotFoundException) {
            if ($this->hideUserNotFoundExceptions) {
                throw new BadCredentialsException('Bad credentials 4', 0, $userNotFoundException);
            }

            throw $userNotFoundException;
        }

        return $user;
    }

    /**
     * Check whether this provider supports the given token.
     *
     * @param TokenInterface $token
     *
     * @return boolean
     */
    public function supports(TokenInterface $token)
    {


        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Provider/LdapAuthenticationProvider : supports");


        return $token instanceof UsernamePasswordToken
            && $token->getProviderKey() === $this->providerKey;
    }
}
