<?php

namespace OVE\AuthentificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\ConfigurationInterface,
  Symfony\Component\Config\Definition\Builder\TreeBuilder;

 
//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;


class Configuration implements ConfigurationInterface
{

  
  public function getConfigTreeBuilder()
  {

    //Cette fonction est appellé lors du vidage de cache quand Symfony à besoin de construire l'arbre de la configuration
    //Même en quittant Firefox et en se connectant, cette fonction n'est pas appellée => Ce paramétrage doit-donc être mis en cache
    //Cette fonction sert à ajouter la configuration du ldap dans la configuration générale
    //-> L'objet $treeBuilder contient l'ensemble du paramètrage de la configuration 
    //-> L'objet $rootNode contient l'ensemble du paramètrage du ldap
    //$log = new Logger('tony');
    //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
    //$log->addWarning("Tony : DependencyInjection/Configuration.php : getConfigTreeBuilder");
    //$log->addWarning("Tony : DependencyInjection/Configuration.php : getConfigTreeBuilder : treeBuilder=".print_r($treeBuilder,true));
    //$log->addWarning("Tony : DependencyInjection/Configuration.php : getConfigTreeBuilder : treeBuilder=".print_r($rootNode,true));
    //$log->addWarning("##############################################################");


    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('ove_authentification');
    //$rootNode->children()->append($this->addGestetabNode())->end();
    //$rootNode->children()->append($this->addWebserviceTokenNode())->end();

    /*
    $rootNode
        ->children()
            ->append($this->addClientNode())
            ->append($this->addUserNode())
            ->append($this->addRoleNode())
            ->append($this->addGestetabNode())
        ->end();
    */

    return $treeBuilder;      
  }
  


  /*
  private function addClientNode()
  {




      
      $treeBuilder = new TreeBuilder();
      $node = $treeBuilder->root('client');

      $node
          ->isRequired()
          ->children()
              ->scalarNode('host')->isRequired()->cannotBeEmpty()->end()
              ->scalarNode('port')->defaultValue(389)->end()
              ->scalarNode('version')->end()
              ->scalarNode('username')->end()
              ->scalarNode('password')->end()
              ->booleanNode('bind_username_before')->defaultFalse()->end()
              ->scalarNode('referrals_enabled')->end()
              ->scalarNode('network_timeout')->end()
              ->booleanNode('skip_roles')->defaultFalse()->end()          
           ->end()
          ;

      return $node;
      
  }
  

  private function addUserNode()
  {




      $treeBuilder = new TreeBuilder();
      $node = $treeBuilder->root('user');

      $node
          ->isRequired()
          ->children()
              ->scalarNode('base_dn')->isRequired()->cannotBeEmpty()->end()
              ->scalarNode('filter')->end()
              ->scalarNode('name_attribute')->defaultValue('uid')->end()
              ->variableNode('attributes')->defaultValue(array())->end()
          ->end()
          ;

      return $node;
  }

  private function addRoleNode()
  {


      $treeBuilder = new TreeBuilder();
      $node = $treeBuilder->root('role');

      $node
          ->children()
              ->scalarNode('base_dn')->isRequired()->cannotBeEmpty()->end()
              ->scalarNode('filter')->end()
              ->scalarNode('name_attribute')->defaultValue('cn')->end()
              ->scalarNode('user_attribute')->defaultValue('member')->end()
              ->scalarNode('user_id')->defaultValue('dn')
                ->validate()
                  ->ifNotInArray(array('dn', 'username'))
                  ->thenInvalid('Only dn or username')
                ->end()
              ->end()
          ->end()
          ;

      return $node;
  }
  */


  /*
  private function addGestetabNode()
  {
      //$log = new Logger('tony');
      //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
      //$log->addWarning("Tony : DependencyInjection/Configuration.php : addGestetabNode");

      $treeBuilder = new TreeBuilder();
      $node = $treeBuilder->root('gestetab');

      $node
          ->isRequired()
          ->children()
              ->scalarNode('host')->end()
              ->scalarNode('reqLogin')->end()
              ->scalarNode('reqPwd')->end()
              ->scalarNode('getDirecteur')->defaultValue(true)->end()
          ->end();
      return $node;
  }
  */

  /*
  private function addWebserviceTokenNode()
  {
      $treeBuilder = new TreeBuilder();
      $node = $treeBuilder->root('webservice_token');
      $node
          ->isRequired()
          ->children()
              ->scalarNode('token_read')->end()
              ->scalarNode('token_write')->end()
          ->end();
      return $node;
  }
  */




}
