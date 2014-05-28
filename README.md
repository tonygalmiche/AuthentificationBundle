OVE - Bundle Symfony d'authentification et de gestion des rôles via LDAP ou MySQL
=========================


## Fonctionnalités

* Fenêtre d'authentification
* Gestion des associations pour autoriser plusieurs méthodes d'authentifcation en fonction de l'association (ex : MySQL, LDAP,..)
* Gestion des utilisateurs, des rôles et de l'affactation des rôles aux utilisateurs
* Thème graphique basé sur Bootstrap 


## Installation


### Installation de composer

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
