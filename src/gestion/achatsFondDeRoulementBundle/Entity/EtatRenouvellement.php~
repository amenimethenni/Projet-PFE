<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Etat_renouvellement
 *
 * @ORM\Table(name="etat_renouvellement")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\EtatRenouvellementRepository")
 */
class EtatRenouvellement
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
     * @ORM\OneToMany(targetEntity="RenouvellementHasEtatRenouvellement", mappedBy="etatRenouvellement", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $renouvellements;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->renouvellements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return EtatRenouvellement
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
     * Add renouvellement
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement $renouvellement
     *
     * @return EtatRenouvellement
     */
    public function addRenouvellement(\gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement $renouvellement)
    {
        $this->renouvellements[] = $renouvellement;

        return $this;
    }

    /**
     * Remove renouvellement
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement $renouvellement
     */
    public function removeRenouvellement(\gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement $renouvellement)
    {
        $this->renouvellements->removeElement($renouvellement);
    }

    /**
     * Get renouvellements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRenouvellements()
    {
        return $this->renouvellements;
    }
}
