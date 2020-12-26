<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uniterattache
 *
 * @ORM\Table(name="uniterattache")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\UniterattacheRepository")
 */
class Uniterattache
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
     * @var \Facure
     *
     * @ORM\ManyToOne(targetEntity="Unite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unite_id", referencedColumnName="id")
     * })
     */
    private $unitee;


    /**
     * Get id
     *
     * @return int
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
     * @return Uniterattache
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
     * Set unitee
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Unite $unitee
     *
     * @return Uniterattache
     */
    public function setUnitee(\gestion\achatsFondDeRoulementBundle\Entity\Unite $unitee = null)
    {
        $this->unitee = $unitee;

        return $this;
    }

    /**
     * Get unitee
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Unite
     */
    public function getUnitee()
    {
        return $this->unitee;
    }
}
