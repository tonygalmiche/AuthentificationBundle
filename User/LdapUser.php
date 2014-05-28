<?php

namespace OVE\AuthentificationBundle\User;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;


//use Monolog\Logger;
//use Monolog\Handler\StreamHandler;



class LdapUser implements UserInterface, EquatableInterface, \Serializable
{
    protected $username,
        $email,
        $roles,
        $dn,
        $attributes,
        $name,
        $association
        ;


    public function setName($name) {

      //$log = new Logger('tony');
      //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
      //$log->addWarning("Tony : User/LdapUser.php : setName");
      //$log->addWarning("Tony : LdapUser : getRoles=".print_r($this->roles,true));




      //$this->name="Tony Galmiche de setName";
      $this->name=$name;
      return $this;
    }

     public function setAssociation($association) {

      //$log = new Logger('tony');
      //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
      //$log->addWarning("Tony : User/LdapUser.php : setAssociation");


      $this->association=$association;

       return $this;
    }





    public function getRoles()
    {

      //$log = new Logger('tony');
      //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
      //$log->addWarning("Tony : User/LdapUser.php : getRoles");


	//echo "toto et tutu";
	//$x=print_r($this->roles,true);
	//echo $x;
	//echo "\n";	

				//$log = new Logger('tony');
				//$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
				//$log->addWarning("Tony : LdapUser : getRoles : Les roles sont connus");
				//$log->addWarning("Tony : LdapUser : getRoles=".print_r($this->roles,true));



        return $this->roles;
	//return array("ROLE_ADMIN", "ROLE_TONY");
	//return array();







    }

    public function getUserName()
    {
        return $this->username;
    }

    public function getEmail()
    {
        return $this->email;
    }



   public function getName() {

      //$log = new Logger('tony');
      //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
      //$log->addWarning("Tony : User/LdapUser.php : getName");


       return $this->name;
    }

   public function getAssociation() {
       return $this->association;
    }








    public function getPassword()
    {
        return null;
    }

    public function getSalt()
    {
        return null;
    }

    public function getDn()
    {
        return $this->dn;
    }

    public function setDn($dn)
    {
        $this->dn = $dn;

        return $this;
    }

    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute($name)
    {
        return isset($this->attributes[$name]) ? $this->attributes[$name] : null;
    }

    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setRoles(array $roles)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : User/LdapUser.php : setRoles");



        $this->roles = $roles;

        return $this;
    }

    public function addRole($role)
    {

        //$log = new Logger('tony');
        //$log->pushHandler(new StreamHandler('/tmp/tony.log', Logger::WARNING));
        //$log->addWarning("Tony : User/LdapUser.php : addRole");



        //$this->roles[] = $role;
        //$this->roles[] = "ROLE_TEST_TONY";

        return $this;
    }

    public function eraseCredentials()
    {
        return null; //With ldap No credentials with stored ; Maybe forgotten the roles
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof LdapUser
            || $user->getUsername() !== $this->username
            || $user->getEmail() !== $this->email
            || count(array_diff($user->getRoles(), $this->roles)) > 0
            || $user->getDn() !== $this->dn
        ) {
            return false;
        }

        return true;
    }

    public function serialize()
    {
        return serialize(array(
            $this->username,
            $this->email,
            $this->roles,
            $this->dn,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->username,
            $this->email,
            $this->roles,
            $this->dn,
        ) = unserialize($serialized);
    }
}
