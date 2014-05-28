OVE - Bundle Symfony d'authentification et de gestion des rôles via LDAP ou MySQL
=========================


## Fonctionnalités

* Fenêtre d'authentification
* Gestion des associations pour autoriser plusieurs méthodes d'authentifcation en fonction de l'association (ex : MySQL, LDAP,..)
* Gestion des utilisateurs, des rôles et de l'affactation des rôles aux utilisateurs
* Thème graphique basé sur Bootstrap 


## Installation


### Installation de composer

Composer permet de gérer les dépendances et l'installation de modules PHP

Installation : 

    cd /home/votre_login/bin
    curl -s http://getcomposer.org/installer | php

Mise à jour du PATH : 

    vim /home/tony/.profile 
    if [ -d "$HOME/bin" ] ; then
      PATH="$HOME/bin:$PATH"
    fi
    
Utilisation : 

    composer.phar

### Installation de Synfony

Installation de la dernière version 2.3 de Synfony (Synfony 2.4 necessite PHP 5.4) : 

    cd /var/www/procedures
    composer.phar create-project symfony/framework-standard-edition symfony 2.3.*
