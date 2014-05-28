<?php

namespace OVE\AuthentificationBundle\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\Config\Definition\Builder\NodeDefinition,
    Symfony\Component\DependencyInjection\DefinitionDecorator,
    Symfony\Component\DependencyInjection\Reference;

//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;

class LdapFactory extends AbstractFactory
{
    public function __construct()
    {
        $this->addOption('username_parameter', '_username');
        $this->addOption('password_parameter', '_password');
        $this->addOption('csrf_parameter', '_csrf_token');
        $this->addOption('intention', 'ldap_authenticate');
        $this->addOption('post_only', true);


        //Cette fonction est appellée lors du vidage du cache
        //L'objet this contient les paramètres de configuration de la securité
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Factory/LdapFactory.php : __construct");
    }

    public function getPosition()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Factory/LdapFactory.php : getPosition");

        return 'form';
    }

    public function getKey()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Factory/LdapFactory.php : getKey");

        return 'ove-authentification';
    }

    public function addConfiguration(NodeDefinition $node)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Factory/LdapFactory.php : addConfiguration");


        parent::addConfiguration($node);

        $node
            ->children()
                ->scalarNode('csrf_provider')->cannotBeEmpty()->end()
            ->end()
            ;
    }

    protected function getListenerId()
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Factory/LdapFactory.php : getListenerId");

        return 'ove_authentification.security.authentication.listener';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Factory/LdapFactory.php : createAuthProvider");


        $dao = 'security.authentication.provider.dao.'.$id;
        $container
            ->setDefinition($dao, new DefinitionDecorator('security.authentication.provider.dao'))
            ->replaceArgument(0, new Reference($userProviderId))
            ->replaceArgument(2, $id)
        ;

        $provider = 'ove_authentification.security.authentication.provider.'.$id;
        $container
            ->setDefinition($provider, new DefinitionDecorator('ove_authentification.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProviderId))
            ->replaceArgument(1, new Reference($dao))
            ->replaceArgument(4, $id)
            ;


				//Cette fonction est appellée lors du vidage du cache ou lors d'un changement dans les fichiers de configuration
				//L'objet container contient les paramètres de configuration de la securité
				//$log = new Logger('tony');
				//$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
				//$log->addWarning("Tony : LdapFactory : __construct : container=".print_r($container,true));



        return $provider;
    }

    protected function createlistener($container, $id, $config, $userProvider)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Factory/LdapFactory.php : createlistener");



        $listenerId = parent::createListener($container, $id, $config, $userProvider);

        if (isset($config['csrf_provider'])) {
            $container
                ->getDefinition($listenerId)
                ->addArgument(new Reference($config['csrf_provider']))
                ;
        }

        return $listenerId;
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : Factory/LdapFactory.php : createEntryPoint");



        $entryPointId = 'ove_authentification.security.authentication.form_entry_point.'.$id;
        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('ove_authentification.security.authentication.form_entry_point'))
            ->addArgument(new Reference('security.http_utils'))
            ->addArgument($config['login_path'])
            ->addArgument($config['use_forward'])
            ;

        return $entryPointId;
    }
}
