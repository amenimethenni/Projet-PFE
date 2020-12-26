<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeHasEtatDemande
 *
 * @ORM\Table(name="renouvellement_has_etat_renouvellement")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\RenouvellementHasEtatRenouvellementRepository")
 */
class RenouvellementHasEtatRenouvellement
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateEtat", type="datetime")
     */
    private $dateEtat;

    /**
     * @var \EtatDemande
     *
     * @ORM\ManyToOne(targetEntity="EtatRenouvellement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_renouvellement_id", referencedColumnName="id")
     * })
     */
    private $etatRenouvellement;

    /**
     * @var \Demande
     *
     * @ORM\ManyToOne(targetEntity="Renouvellement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="renouvellement_id", referencedColumnName="id")
     * })
     */
    private $renouvellement;

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
     * Set dateEtat
     *
     * @param \DateTime $dateEtat
     *
     * @return DemandeHasEtatDemande
     */
    public function setDateEtat($dateEtat)
    {
        $this->dateEtat = $dateEtat;

        return $this;
    }

    /**
     * Get dateEtat
     *
     * @return \DateTime
     */
    public function getDateEtat()
    {
        return $this->dateEtat;
    }

    /**
     * Set etatDemande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\EtatDemande $etatDemande
     *
     * @return DemandeHasEtatDemande
     */
    public function setEtatDemande(\gestion\achatsFondDeRoulementBundle\Entity\EtatDemande $etatDemande = null)
    {
        $this->etatDemande = $etatDemande;

        return $this;
    }

    /**
     * Get etatDemande
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\EtatDemande
     */
    public function getEtatDemande()
    {
        return $this->etatDemande;
    }

    /**
     * Set demande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Demande $demande
     *
     * @return DemandeHasEtatDemande
     */
    public function setDemande(\gestion\achatsFondDeRoulementBundle\Entity\Demande $demande = null)
    {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Demande
     */
    public function getDemande()
    {
        return $this->demande;
    }

    /**
     * Set etatRenouvellement
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\EtatRenouvellement $etatRenouvellement
     *
     * @return RenouvellementHasEtatRenouvellement
     */
    public function setEtatRenouvellement(\gestion\achatsFondDeRoulementBundle\Entity\EtatRenouvellement $etatRenouvellement = null)
    {
        $this->etatRenouvellement = $etatRenouvellement;

        return $this;
    }

    /**
     * Get etatRenouvellement
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\EtatRenouvellement
     */
    public function getEtatRenouvellement()
    {
        return $this->etatRenouvellement;
    }

    /**
     * Set renouvellement
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Renouvellement $renouvellement
     *
     * @return RenouvellementHasEtatRenouvellement
     */
    public function setRenouvellement(\gestion\achatsFondDeRoulementBundle\Entity\Renouvellement $renouvellement = null)
    {
        $this->renouvellement = $renouvellement;

        return $this;
    }

    /**
     * Get renouvellement
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Renouvellement
     */
    public function getRenouvellement()
    {
        return $this->renouvellement;
    }
}
