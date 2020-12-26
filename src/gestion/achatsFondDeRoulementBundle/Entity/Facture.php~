<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facture
 *
 * @ORM\Table(name="facture")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\FactureRepository")
 */
class Facture
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
     * @ORM\Column(name="dateFacture", type="date")
     */
    private $dateFacture;

    /**
     * @var string
     *
     * @ORM\Column(name="fichierFacture", type="string", length=255)
     */
    private $fichierFacture;
    
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
     * @ORM\OneToMany(targetEntity="LigneFacture", mappedBy="facture", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $lignesFactures;

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
     * Set numero
     *
     * @param string $numero
     *
     * @return Facture
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
     * Set dateFacture
     *
     * @param \DateTime $dateFacture
     *
     * @return Facture
     */
    public function setDateFacture($dateFacture)
    {
        $this->dateFacture = $dateFacture;

        return $this;
    }

    /**
     * Get dateFacture
     *
     * @return \DateTime
     */
    public function getDateFacture()
    {
        return $this->dateFacture;
    }

    /**
     * Set fournisseur
     *
     * @param integer $fournisseur
     *
     * @return Facture
     */
    public function setFournisseur($fournisseur)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return int
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Set fichierFacture
     *
     * @param string $fichierFacture
     *
     * @return Facture
     */
    public function setFichierFacture($fichierFacture)
    {
        $this->fichierFacture = $fichierFacture;

        return $this;
    }

    /**
     * Get fichierFacture
     *
     * @return string
     */
    public function getFichierFacture()
    {
        return $this->fichierFacture;
    }

    /**
     * Set totalHT
     *
     * @param float $totalHT
     *
     * @return Facture
     */
    public function setTotalHT($totalHT)
    {
        $this->totalHT = $totalHT;

        return $this;
    }

    /**
     * Get totalHT
     *
     * @return float
     */
    public function getTotalHT()
    {
        return $this->totalHT;
    }

    /**
     * Set totalTva
     *
     * @param float $totalTva
     *
     * @return Facture
     */
    public function setTotalTva($totalTva)
    {
        $this->totalTva = $totalTva;

        return $this;
    }

    /**
     * Get totalTva
     *
     * @return float
     */
    public function getTotalTva()
    {
        return $this->totalTva;
    }

    /**
     * Set timbres
     *
     * @param float $timbres
     *
     * @return Facture
     */
    public function setTimbres($timbres)
    {
        $this->timbres = $timbres;

        return $this;
    }

    /**
     * Get timbres
     *
     * @return float
     */
    public function getTimbres()
    {
        return $this->timbres;
    }

    /**
     * Set totalTtc
     *
     * @param float $totalTtc
     *
     * @return Facture
     */
    public function setTotalTtc($totalTtc)
    {
        $this->totalTtc = $totalTtc;

        return $this;
    }

    /**
     * Get totalTtc
     *
     * @return float
     */
    public function getTotalTtc()
    {
        return $this->totalTtc;
    }

    /**
     * Set achat
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Achat $achat
     *
     * @return Facture
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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lignesFactures = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add lignesFacture
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\LigneFacture $lignesFacture
     *
     * @return Facture
     */
    public function addLignesFacture(\gestion\achatsFondDeRoulementBundle\Entity\LigneFacture $lignesFacture)
    {
        $this->lignesFactures[] = $lignesFacture;

        return $this;
    }

    /**
     * Remove lignesFacture
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\LigneFacture $lignesFacture
     */
    public function removeLignesFacture(\gestion\achatsFondDeRoulementBundle\Entity\LigneFacture $lignesFacture)
    {
        $this->lignesFactures->removeElement($lignesFacture);
    }

    /**
     * Get lignesFactures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLignesFactures()
    {
        return $this->lignesFactures;
    }
}
