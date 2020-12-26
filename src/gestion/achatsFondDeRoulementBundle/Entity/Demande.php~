<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Demande
 *
 * @ORM\Table(name="demande")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\DemandeRepository")
 */
class Demande
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
     * @ORM\Column(name="date_demande", type="date")
     */
    private $dateDemande;

    /**
     * @var \EtatDemande
     *
     * @ORM\ManyToOne(targetEntity="Unite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unite_id", referencedColumnName="id")
     * })
     */
    private $unite;

    /**
     * @var string
     *
     * @ORM\Column(name="fichier_bcn", type="string", length=255, nullable=true)
     */
    private $fichierBcn;

    /**
     * @var string
     *
     * @ORM\Column(name="lien_bcn", type="string", length=255, nullable=true)
     */
    private $lienBcn;

    /**
     * @var string
     *
     * @ORM\Column(name="numero_bcn", type="string", length=255, nullable=false)
     */
    private $numeroBcn;

    /**
     * @var \EtatDemande
     *
     * @ORM\ManyToOne(targetEntity="Unite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unite_demandeuse_id", referencedColumnName="id")
     * })
     */
    private $uniteDemandeuse;

    /**
     * @ORM\OneToMany(targetEntity="LigneDemande", mappedBy="demande", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $lignesDemandes;

    /**
     * @ORM\OneToMany(targetEntity="DemandeHasEtatDemande", mappedBy="demande", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $etatsDemandes;

    /**
     * @var \Achat
     *
     * @ORM\ManyToOne(targetEntity="Achat",inversedBy="demandes", cascade={"persist","remove"})
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="achat_id", referencedColumnName="id")
     * })
     */
    private $achat;
        
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lignesDemandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etatsDemandes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set dateDemande
     *
     * @param \DateTime $dateDemande
     *
     * @return Demande
     */
    public function setDateDemande($dateDemande)
    {
        $this->dateDemande = $dateDemande;

        return $this;
    }

    /**
     * Get dateDemande
     *
     * @return \DateTime
     */
    public function getDateDemande()
    {
        return $this->dateDemande;
    }

    /**
     * Set fichierBcn
     *
     * @param string $fichierBcn
     *
     * @return Demande
     */
    public function setFichierBcn($fichierBcn)
    {
        $this->fichierBcn = $fichierBcn;

        return $this;
    }

    /**
     * Get fichierBcn
     *
     * @return string
     */
    public function getFichierBcn()
    {
        return $this->fichierBcn;
    }

    /**
     * Set lienBcn
     *
     * @param string $lienBcn
     *
     * @return Demande
     */
    public function setLienBcn($lienBcn)
    {
        $this->lienBcn = $lienBcn;

        return $this;
    }

    /**
     * Get lienBcn
     *
     * @return string
     */
    public function getLienBcn()
    {
        return $this->lienBcn;
    }

    /**
     * Set numeroBcn
     *
     * @param string $numeroBcn
     *
     * @return Demande
     */
    public function setNumeroBcn($numeroBcn)
    {
        $this->numeroBcn = $numeroBcn;

        return $this;
    }

    /**
     * Get numeroBcn
     *
     * @return string
     */
    public function getNumeroBcn()
    {
        return $this->numeroBcn;
    }

    /**
     * Set unite
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Unite $unite
     *
     * @return Demande
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
     * Set uniteDemandeuse
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Unite $uniteDemandeuse
     *
     * @return Demande
     */
    public function setUniteDemandeuse(\gestion\achatsFondDeRoulementBundle\Entity\Unite $uniteDemandeuse = null)
    {
        $this->uniteDemandeuse = $uniteDemandeuse;

        return $this;
    }

    /**
     * Get uniteDemandeuse
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Unite
     */
    public function getUniteDemandeuse()
    {
        return $this->uniteDemandeuse;
    }

    /**
     * Add lignesDemande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\LigneDemande $lignesDemande
     *
     * @return Demande
     */
    public function addLignesDemande(\gestion\achatsFondDeRoulementBundle\Entity\LigneDemande $lignesDemande)
    {
        $this->lignesDemandes[] = $lignesDemande;

        return $this;
    }

    /**
     * Remove lignesDemande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\LigneDemande $lignesDemande
     */
    public function removeLignesDemande(\gestion\achatsFondDeRoulementBundle\Entity\LigneDemande $lignesDemande)
    {
        $this->lignesDemandes->removeElement($lignesDemande);
    }

    /**
     * Get lignesDemandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignesDemandes()
    {
        return $this->lignesDemandes;
    }

    /**
     * Add etatsDemande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande $etatsDemande
     *
     * @return Demande
     */
    public function addEtatsDemande(\gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande $etatsDemande)
    {
        $this->etatsDemandes[] = $etatsDemande;

        return $this;
    }

    /**
     * Remove etatsDemande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande $etatsDemande
     */
    public function removeEtatsDemande(\gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande $etatsDemande)
    {
        $this->etatsDemandes->removeElement($etatsDemande);
    }

    /**
     * Get etatsDemandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtatsDemandes()
    {
        return $this->etatsDemandes;
    }

    /**
     * Set achat
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Achat $achat
     *
     * @return Demande
     */
    public function setAchat(\gestion\achatsFondDeRoulementBundle\Entity\Achat $achat)
    {
        $this->achat = $achat;
        return $this;
    }

    /**
     * Get achat
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Achat
     */
    public function getAchat()
    {
        return $this->achat;
    }
}
