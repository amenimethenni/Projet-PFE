<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="devis")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\DevisRepository")
 */
class Devis
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
     * @ORM\Column(name="numero", type="string", length=255)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDevis", type="date")
     */
    private $dateDevis;

    /**
     * @var string
     *
     * @ORM\Column(name="fichierDevis", type="string", length=255, nullable=true)
     */
    private $fichierDevis;

    /**
     * @var \Fournisseur
     *
     * @ORM\ManyToOne(targetEntity="Fournisseur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fournisseur_id", referencedColumnName="id")
     * })
     */
    private $fournisseur;

    /**
     * @ORM\OneToMany(targetEntity="LigneDevis", mappedBy="devis", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $lignesDevis;

    /**
     * @var \Achat
     *
     * @ORM\ManyToOne(targetEntity="Achat")
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
        $this->lignesDevis = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numero
     *
     * @param string $numero
     *
     * @return Devis
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set dateDevis
     *
     * @param \DateTime $dateDevis
     *
     * @return Devis
     */
    public function setDateDevis($dateDevis)
    {
        $this->dateDevis = $dateDevis;

        return $this;
    }

    /**
     * Get dateDevis
     *
     * @return \DateTime
     */
    public function getDateDevis()
    {
        return $this->dateDevis;
    }

    /**
     * Set fichierDevis
     *
     * @param string $fichierDevis
     *
     * @return Devis
     */
    public function setFichierDevis($fichierDevis)
    {
        $this->fichierDevis = $fichierDevis;

        return $this;
    }

    /**
     * Get fichierDevis
     *
     * @return string
     */
    public function getFichierDevis()
    {
        return $this->fichierDevis;
    }

    /**
     * Set fournisseur
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Fournisseur $fournisseur
     *
     * @return Devis
     */
    public function setFournisseur(\gestion\achatsFondDeRoulementBundle\Entity\Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Add lignesDevi
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\LigneDevis $lignesDevi
     *
     * @return Devis
     */
    public function addLignesDevi(\gestion\achatsFondDeRoulementBundle\Entity\LigneDevis $lignesDevi)
    {
        $this->lignesDevis[] = $lignesDevi;

        return $this;
    }

    /**
     * Remove lignesDevi
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\LigneDevis $lignesDevi
     */
    public function removeLignesDevi(\gestion\achatsFondDeRoulementBundle\Entity\LigneDevis $lignesDevi)
    {
        $this->lignesDevis->removeElement($lignesDevi);
    }

    /**
     * Get lignesDevis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignesDevis()
    {
        return $this->lignesDevis;
    }

    /**
     * Set achat
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Achat $achat
     *
     * @return Devis
     */
    public function setAchat(\gestion\achatsFondDeRoulementBundle\Entity\Achat $achat = null)
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
