<?php

namespace OVE\AuthentificationBundle\EventListener;

use Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Symfony\Component\Form\Extension\Csrf\CsrfProvider\CsrfProviderInterface,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpKernel\Log\LoggerInterface,
    Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface,
    Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken,
    Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException,
    Symfony\Component\Security\Core\SecurityContextInterface,
    Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface,
    Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface,
    Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener,
    Symfony\Component\Security\Http\HttpUtils,
    Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;

use OVE\AuthentificationBundle\Authentication\Token\LdapToken;


//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;


class LdapListener extends AbstractAuthenticationListener
{
    public function __construct(SecurityContextInterface $securityContext,
                                AuthenticationManagerInterface $authenticationManager,
                                SessionAuthenticationStrategyInterface $sessionStrategy,
                                HttpUtils $httpUtils,
                                $providerKey,
                                AuthenticationSuccessHandlerInterface $successHandler = null,
                                AuthenticationFailureHandlerInterface $failureHandler = null,
                                array $options = array(),
                                LoggerInterface $logger = null,
                                EventDispatcherInterface $dispatcher = null,
                                CsrfProviderInterface $csrfProvider = null)
    {



        parent::__construct(
            $securityContext,
            $authenticationManager,
            $sessionStrategy,
            $httpUtils,
            $providerKey,
            $successHandler,
            $failureHandler,
            array_merge(array(
                'username_parameter' => '_username',
                'password_parameter' => '_password',
                'csrf_parameter'     => '_csrf_token',
                'intention'          => 'ldap_authenticate',
                'post_only'          => true,
            ), $options),
            $logger,
            $dispatcher
        );


        //Cette méthode est appellée 2 fois lors de la connexion, 3 fois lors de la deconnexion et 1 fois pour chaque page consultée
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : EventListener/LdapListener.php : construct");
        //$log->addWarning("Tony : LdapListener : construct : securityContext=".print_r($securityContext,true));
        //$log->addWarning("Tony : LdapListener : construct : authenticationManager=".print_r($authenticationManager,true));
        //$log->addWarning("Tony : LdapListener : construct : sessionStrategy=".print_r($sessionStrategy,true));
        //$log->addWarning("Tony : LdapListener : construct : httpUtils=".print_r($httpUtils,true));
        //$log->addWarning("Tony : LdapListener : construct : providerKey=".print_r($providerKey,true));
        //$log->addWarning("Tony : LdapListener : construct : successHandler=".print_r($successHandler,true));
        //$log->addWarning("Tony : LdapListener : construct : failureHandler=".print_r($failureHandler,true));
        //$log->addWarning("Tony : LdapListener : construct : logger=".print_r($logger,true));
        //$log->addWarning("Tony : LdapListener : construct : dispatcher=".print_r($dispatcher,true));


        
        $this->csrfProvider = $csrfProvider;
    }

    /**
     * {@inheritdoc}
     */
    protected function requiresAuthentication(Request $request)
    {

        //l'objet $request contient enormement d'informations (varialbes d'envirionnment)
        //Cette méthode est appellée 1 fois lors de la connexion, 2 fois lors de la deconnexion et 1 fois pour chaque page consultée
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : EventListener/LdapListener.php : requiresAuthentication");
        //$log->addWarning("Tony : LdapListener : requiresAuthentication : POST=".print_r($_POST,true));



        if ($this->options['post_only'] && !$request->isMethod('post')) {
            return false;
        }

        return parent::requiresAuthentication($request);
    }

    
    public function attemptAuthentication(Request $request)
    {
        /*
        //Cette methode n'est jamais logguée mais elle est obligatoire dans l'interface de la class
        // -> Je l'ai donc commenté



        if ($this->options['post_only'] && 'post' !== strtolower($request->getMethod())) {
            if (null !== $this->logger) {
                $this->logger->debug(sprintf('Authentication method not supported: %s.', $request->getMethod()));
            }
            return null;
        }

        if (null !== $this->csrfProvider) {
            $csrfToken = $request->get($this->options['csrf_parameter'], null, true);

            if (false === $this->csrfProvider->isCsrfTokenValid($this->options['intention'], $csrfToken)) {
                throw new InvalidCsrfTokenException('Invalid CSRF token.');
            }
        }
        $username = trim($request->get($this->options['username_parameter'], null, true));
        $password = $request->get($this->options['password_parameter'], null, true);
        $request->getSession()->set(SecurityContextInterface::LAST_USERNAME, $username);
        return $this->authenticationManager->authenticate(new UsernamePasswordToken($username, $password, $this->providerKey));
        */
    }
    
}
