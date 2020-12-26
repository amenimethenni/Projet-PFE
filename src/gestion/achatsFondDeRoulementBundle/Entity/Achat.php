<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * achat
 *
 * @ORM\Table(name="achat")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\achatRepository")
 */
class Achat
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
     * @ORM\Column(name="date_achat", type="date")
     */
    private $dateAchat;

    /**
     * @ORM\OneToOne(targetEntity="Facture", cascade={"persist","remove"})
     */
    private $facture;

    /**
     * @ORM\OneToMany(targetEntity="Devis", mappedBy="achat", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $deviss;

    /**
     * @ORM\OneToMany(targetEntity="Demande", mappedBy="demande", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $demandes;

    /**
     * @var \Facure
     *
     * @ORM\ManyToOne(targetEntity="Unite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unite_id", referencedColumnName="id")
     * })
     */
    private $unite;
    
    /**
     * @var \Renouvellement
     *
     * @ORM\ManyToOne(targetEntity="Renouvellement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="renouvellement_id", referencedColumnName="id")
     * })
     */
    private $renouvellement;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->deviss = new \Doctrine\Common\Collections\ArrayCollection();
        $this->demandes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateAchat
     *
     * @param string $dateAchat
     *
     * @return Achat
     */
    public function setDateAchat($dateAchat)
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    /**
     * Get dateAchat
     *
     * @return string
     */
    public function getDateAchat()
    {
        return $this->dateAchat;
    }

    /**
     * Set facture
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Facture $facture
     *
     * @return Achat
     */
    public function setFacture(\gestion\achatsFondDeRoulementBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Add deviss
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Devis $deviss
     *
     * @return Achat
     */
    public function addDeviss(\gestion\achatsFondDeRoulementBundle\Entity\Devis $deviss)
    {
        $this->deviss[] = $deviss;

        return $this;
    }

    /**
     * Remove deviss
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Devis $deviss
     */
    public function removeDeviss(\gestion\achatsFondDeRoulementBundle\Entity\Devis $deviss)
    {
        $this->deviss->removeElement($deviss);
    }

    /**
     * Get deviss
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDeviss()
    {
        return $this->deviss;
    }

    /**
     * Add demande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Demande $demande
     *
     * @return Achat
     */
    public function addDemande(\gestion\achatsFondDeRoulementBundle\Entity\Demande $demande)
    {
        $demande->setAchat($this);
        $this->demandes[] = $demande;

        return $this;
    }

    /**
     * Remove demande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Demande $demande
     */
    public function removeDemande(\gestion\achatsFondDeRoulementBundle\Entity\Demande $demande)
    {
        $this->demandes->removeElement($demande);
    }

    /**
     * Get demandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDemandes()
    {
        return $this->demandes;
    }

    /**
     * Set unite
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Unite $unite
     *
     * @return Achat
     */
    public function setUnite(\gestion\achatsFondDeRoulementBundle\Entity\Unite $unite = null)
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * Get unite
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Unite
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * Set renouvellement
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Renouvellement $renouvellement
     *
     * @return Achat
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
