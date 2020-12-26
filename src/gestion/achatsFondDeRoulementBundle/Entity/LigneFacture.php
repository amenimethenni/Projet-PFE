<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneFacture
 *
 * @ORM\Table(name="ligne_facture")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\LigneFactureRepository")
 */
class LigneFacture
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
     * @var \Produit
     *
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit_id", referencedColumnName="id")
     * })
     */
    private $produit;

    /**
     * @var float
     *
     * @ORM\Column(name="qte", type="float")
     */
    private $qte;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_ht", type="string", length=255)
     */
    private $prixHt;

    /**
     * @var \TauxTva
     *
     * @ORM\ManyToOne(targetEntity="TauxTva")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="tauxTva_id", referencedColumnName="id")
     * })
     */
    private $tauxTva;

    /**
     * @var float
     *
     * @ORM\Column(name="remise", type="float")
     */
    private $remise;

    /**
     * @var \Facture
     *
     * @ORM\ManyToOne(targetEntity="Facture")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="facture_id", referencedColumnName="id")
     * })
     */
    private $facture;


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
     * Set produit
     *
     * @param integer $produit
     *
     * @return LigneFacture
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return int
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set qte
     *
     * @param float $qte
     *
     * @return LigneFacture
     */
    public function setQte($qte)
    {
        $this->qte = $qte;

        return $this;
    }

    /**
     * Get qte
     *
     * @return float
     */
    public function getQte()
    {
        return $this->qte;
    }

    /**
     * Set prixHt
     *
     * @param string $prixHt
     *
     * @return LigneFacture
     */
    public function setPrixHt($prixHt)
    {
        $this->prixHt = $prixHt;

        return $this;
    }

    /**
     * Get prixHt
     *
     * @return string
     */
    public function getPrixHt()
    {
        return $this->prixHt;
    }

    /**
     * Set tauxTva
     *
     * @param string $tauxTva
     *
     * @return LigneFacture
     */
    public function setTauxTva($tauxTva)
    {
        $this->tauxTva = $tauxTva;

        return $this;
    }

    /**
     * Get tauxTva
     *
     * @return string
     */
    public function getTauxTva()
    {
        return $this->tauxTva;
    }

    /**
     * Set remise
     *
     * @param float $remise
     *
     * @return LigneFacture
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise
     *
     * @return float
     */
    public function getRemise()
    {
        return $this->remise;
    }

    /**
     * Set facture
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Facture $facture
     *
     * @return LigneFacture
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
}
