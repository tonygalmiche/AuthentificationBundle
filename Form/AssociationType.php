<?php

namespace OVE\AuthentificationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AssociationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('name'               , 'text'  , array('attr' => array('size' => '40'), 'label' => 'Nom de l\'association'))
            ->add('type'               , 'choice', array(                                 'label' => 'Type', 'empty_value' => 'Veuillez choisir', 'choices' => array('ldap' => 'LDAP', 'mysql' => 'MySql', 'google' => 'Google')))
            ->add('ldapServerAdress'   , null    , array('attr' => array('size' => '20'), 'label' => 'Adresse du serveur LDAP'))
            ->add('ldapDn'             , null    , array('attr' => array('size' => '40'), 'label' => 'DN'))
            ->add('mysqlServerAdress'  , null    , array('attr' => array('size' => '20'), 'label' => 'Adresse du serveur MySql'))
            ->add('mysqlDatabase'      , null    , array('attr' => array('size' => '20'), 'label' => 'Base MySql'))
            ->add('mysqlUser'          , null    , array('attr' => array('size' => '20'), 'label' => 'Utilisateur MySql'))
            ->add('mysqlPassword'      , null    , array('attr' => array('size' => '20'), 'label' => 'Mot de passe'))
            ->add('mysqlUserTable'     , null    , array('attr' => array('size' => '20'), 'label' => 'Table utilisateur'))
            ->add('mysqlLoginField'    , null    , array('attr' => array('size' => '20'), 'label' => 'Champ "Login"'))
            ->add('mysqlPasswordField' , null    , array('attr' => array('size' => '20'), 'label' => 'Champ "Mot de passe"'))
            ->add('mysqlMailField'     , null    , array('attr' => array('size' => '40'), 'label' => 'Champ "Mail"'))
            ->add('mysqlFirstNameField', null    , array('attr' => array('size' => '20'), 'label' => 'Champ "Prénom"'))
            ->add('mysqlLastNameField' , null    , array('attr' => array('size' => '20'), 'label' => 'Champ "Nom"'))
        ;


        /*
        $builder
            ->add('name'               , 'text'  , array('attr' => array('size' => '40'), 'label' => 'Nom de l\'association'))
            ->add('type'               , 'choice', array(                                 'label' => 'Type', 'empty_value' => 'Veuillez choisir', 'choices' => array('ldap' => 'LDAP', 'mysql' => 'MySql', 'google' => 'Google')))
            ->add('ldapServerAdress'   , null    , array('attr' => array('size' => '20'), 'label' => 'Adresse du serveur LDAP'))
            ->add('ldapPort'           , null    , array('attr' => array('size' => '10' ), 'label' => 'Port'))
            ->add('ldapDn'             , null    , array('attr' => array('size' => '40'), 'label' => 'DN'))
            ->add('ldapPassword'       , null    , array('attr' => array('size' => '20'), 'label' => 'Mot de passe'))
            ->add('ldapDbRoot'         , null    , array('attr' => array('size' => '40'), 'label' => 'Racine de l\'annuaire LDAP'))
            ->add('ldapFilter'         , null    , array('attr' => array('size' => '40'), 'label' => 'Filtre'))
            ->add('mysqlServerAdress'  , null    , array('attr' => array('size' => '20'), 'label' => 'Adresse du serveur MySql'))
            ->add('mysqlDatabase'      , null    , array('attr' => array('size' => '20'), 'label' => 'Base MySql'))
            ->add('mysqlUser'          , null    , array('attr' => array('size' => '20'), 'label' => 'Utilisateur MySql'))
            ->add('mysqlPassword'      , null    , array('attr' => array('size' => '20'), 'label' => 'Mot de passe'))
            ->add('mysqlUserTable'     , null    , array('attr' => array('size' => '20'), 'label' => 'Table utilisateur'))
            ->add('mysqlLoginField'    , null    , array('attr' => array('size' => '20'), 'label' => 'Champ "Login"'))
            ->add('mysqlPasswordField' , null    , array('attr' => array('size' => '20'), 'label' => 'Champ "Mot de passe"'))
            ->add('mysqlMailField'     , null    , array('attr' => array('size' => '40'), 'label' => 'Champ "Mail"'))
            ->add('mysqlFirstNameField', null    , array('attr' => array('size' => '20'), 'label' => 'Champ "Prénom"'))
            ->add('mysqlLastNameField' , null    , array('attr' => array('size' => '20'), 'label' => 'Champ "Nom"'))
        ;
        */

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OVE\AuthentificationBundle\Entity\Association'
        ));
    }

    public function getName()
    {
        return 'ove_authentificationbundle_associationtype';
    }
}
