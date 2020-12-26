<?php

namespace administrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity(repositoryClass="administrationBundle\Repository\ProfilRepository")
 */
class Profil
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    /**
    * @ORM\ManyToMany(targetEntity="Fonctionnalite", cascade={"persist"})
    */
    private $fonctionnalites;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->fonctionnalites = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Profil
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

    /**
     * Add fonctionnalite
     *
     * @param \administrationBundle\Entity\Fonctionnalite $fonctionnalite
     *
     * @return Profil
     */
    public function addFonctionnalite(\administrationBundle\Entity\Fonctionnalite $fonctionnalite)
    {
        $this->fonctionnalites[] = $fonctionnalite;

        return $this;
    }

    /**
     * Remove fonctionnalite
     *
     * @param \administrationBundle\Entity\Fonctionnalite $fonctionnalite
     */
    public function removeFonctionnalite(\administrationBundle\Entity\Fonctionnalite $fonctionnalite)
    {
        $this->fonctionnalites->removeElement($fonctionnalite);
    }

    /**
     * Get fonctionnalites
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFonctionnalites()
    {
        return $this->fonctionnalites;
    }
}
