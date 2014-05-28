<?php

namespace OVE\AuthentificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * utilisateur
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class utilisateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=50)
     */
    private $login;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_association", type="integer")
     */
    private $id_association;





     /**
     * @var ArrayCollection role $utilisateurs
     *
     * Inverse Side
     *
     * @ORM\ManyToMany(targetEntity="role", mappedBy="utilisateurs", cascade={"persist", "merge"})
     *
     */
    private $roles;



    /**
     * Add Role
     *
     * @param role $role
     */
    public function addRole(role $role)
    {
        // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
        if (!$this->roles->contains($role)) {
            //if (!$role->getUtilisateurs()->contains($this)) {
							$this->roles->add($role);
						//}
        }
    }


     /**
     * Remove Role
     *
     * @param role $role
     */
    public function removeRole(role $role)
    {
        // Si l'objet ne fait pas partie de la collection on ne le supprimer pas
        if ($this->roles->contains($role)) {
          $this->roles->removeElement($role);
        }
    }









    public function setRoles($items)
    {
        if ($items instanceof ArrayCollection || is_array($items)) {
            foreach ($items as $item) {
                $this->addRole($item);
            }
        } elseif ($items instanceof role) {
            $this->addRole($items);
        } else {
            throw new \Exception("$items must be an instance of Role or ArrayCollection");
        }
    }

 
    /**
     * Get ArrayCollection
     *
     * @return ArrayCollection $roles
     */
    public function getRoles()
    {
        return $this->roles;
    }
 
		
    public function __construct()
    {
        $this->roles = new ArrayCollection();
    }
		






















    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return utilisateur
     */
    public function setLogin($login)
    {
        $this->login = $login;
    
        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set id_association
     *
     * @param integer $idAssociation
     * @return utilisateur
     */
    public function setIdAssociation($idAssociation)
    {
        $this->id_association = $idAssociation;
    
        return $this;
    }

    /**
     * Get id_association
     *
     * @return integer 
     */
    public function getIdAssociation()
    {
        return $this->id_association;
    }
}
