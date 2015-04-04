<?php

namespace OVE\AuthentificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * parametresauth
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="OVE\AuthentificationBundle\Entity\parametresauthRepository")
 */
class parametresauth
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
     * @ORM\Column(name="introduction", type="text")
     */
    private $introduction;


    /**
     * @var string
     *
     * @ORM\Column(name="information", type="text")
     */
    private $information;


    /**
     * @var string
     *
     * @ORM\Column(name="css", type="string", length=255)
     */
    private $css;




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
     * Set introduction
     *
     * @param string $introduction
     * @return parametresauth
     */
    public function setIntroduction($introduction)
    {
        $this->introduction = $introduction;

        return $this;
    }

    /**
     * Get introduction
     *
     * @return string 
     */
    public function getIntroduction()
    {
        return $this->introduction;
    }

    /**
     * Set css
     *
     * @param string $css
     * @return parametresauth
     */
    public function setCss($css)
    {
        $this->css = $css;

        return $this;
    }

    /**
     * Get css
     *
     * @return string 
     */
    public function getCss()
    {
        return $this->css;
    }

    /**
     * Set information
     *
     * @param string $information
     * @return parametresauth
     */
    public function setInformation($information)
    {
        $this->information = $information;

        return $this;
    }

    /**
     * Get information
     *
     * @return string 
     */
    public function getInformation()
    {
        return $this->information;
    }
}
