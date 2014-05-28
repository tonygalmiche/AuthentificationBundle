<?php

namespace OVE\AuthentificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * role
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class role
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
     * @ORM\Column(name="role", type="string", length=50)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;





    /**
     * @var ArrayCollection utilisateur $roles
     *
     * Inverse Side
     *
     * @ORM\ManyToMany(targetEntity="utilisateur", inversedBy="roles")
     *
     */
    private $utilisateurs;



    /**
     * Add Utilisateur
     *
     * @param utilisateur $utilisateur
     */
    public function addUtilisateur(utilisateur $utilisateur)
    {
        // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
        }
    }


    /**
     * Remove Utilisateur
     *
     * @param utilisateur $utilisateur
     */
    public function removeUtilisateur(utilisateur $utilisateur)
    {
        // Si l'objet ne fait pas partie de la collection on ne le supprimer pas
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
        }
    }








 
    public function setUtilisateurs($items)
    {
        if ($items instanceof ArrayCollection || is_array($items)) {
            foreach ($items as $item) {
                $this->addUtilisateur($item);
            }
        } elseif ($items instanceof role) {
            $this->addUtilisateur($items);
        } else {
            throw new \Exception("$items must be an instance of Utilisateur or ArrayCollection");
        }
    }
 

    /**
     * Get ArrayCollection
     *
     * @return ArrayCollection $roles
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }
 

    public function __construct()
    {
        $this->utilisateurs = new ArrayCollection();
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
     * Set role
     *
     * @param string $role
     * @return role
     */
    public function setRole($role)
    {
        $this->role = $role;
    
        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return role
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    
        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
}
