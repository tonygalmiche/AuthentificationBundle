<?php

namespace OVE\AuthentificationBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension,
    Symfony\Component\DependencyInjection\ContainerBuilder,
    Symfony\Component\DependencyInjection\Loader\XmlFileLoader,
    Symfony\Component\Config\FileLocator;


//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;


class OVEAuthentificationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {


        //Cette fonction est appellée lors du vidage du cache ou lors de la modification de ce fichier quand Symfony à besoin de lire la configuration
        //Cette fonction permet de mettre à jour la configuration
        //-> Le tableau $configs contient la valeur des paramètres de confiugration du Bundle
        //-> L'objet $container contient l'ensemble des paramètres de configuration
        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : DependencyInjection / OVEAuthentificationExtension.php : load");
        //$log->addWarning("Tony : IMAGLdapExtension : load : config=".print_r($config,true));
        //$log->addWarning("Tony : IMAGLdapExtension : load : container=".print_r($container,true));
        //$log->addWarning("##############################################################");



        $loader = new XMLFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('security_ldap.xml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('ove_authentification.ldap_connection.params', $config);

        //$container->setParameter('ove_authentification.authentication.bind_username_before', $config['client']['bind_username_before']);
        $container->setParameter('ove_authentification.authentication.bind_username_before', false);


        

    }

    public function getAlias()
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : DependencyInjection / OVEAuthentificationExtension.php : getAlias");

        return "ove_authentification";
    }
}
