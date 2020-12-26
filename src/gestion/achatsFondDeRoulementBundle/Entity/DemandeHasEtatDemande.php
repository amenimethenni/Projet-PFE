<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DemandeHasEtatDemande
 *
 * @ORM\Table(name="demande_has_etat_demande")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\DemandeHasEtatDemandeRepository")
 */
class DemandeHasEtatDemande
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
     * @ORM\ManyToOne(targetEntity="EtatDemande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="etat_demande_id", referencedColumnName="id")
     * })
     */
    private $etatDemande;

    /**
     * @var \Demande
     *
     * @ORM\ManyToOne(targetEntity="Demande")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="demande_id", referencedColumnName="id")
     * })
     */
    private $demande;

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
}
