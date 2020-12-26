<?php

namespace administrationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fonctionnalite
 *
 * @ORM\Table(name="fonctionnalite")
 * @ORM\Entity(repositoryClass="administrationBundle\Repository\FonctionnaliteRepository")
 */
class Fonctionnalite
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
     * @var \Module
     *
     * @ORM\ManyToOne(targetEntity="Module", inversedBy="fonctionnalites", cascade={"persist", "remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="module_id", referencedColumnName="id")
     * })
     */
    private $module;

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
     * @return Fonctionnalite
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
     * Set module
     *
     * @param \administrationBundle\Entity\Module $module
     *
     * @return Fonctionnalite
     */
    public function setModule(\administrationBundle\Entity\Module $module = null)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return \administrationBundle\Entity\Module
     */
    public function getModule()
    {
        return $this->module;
    }
}
