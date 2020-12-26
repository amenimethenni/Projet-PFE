<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneDemande
 *
 * @ORM\Table(name="ligne_demande")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\LigneDemandeRepository")
 */
class LigneDemande
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
     * @var \Facture
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
     * Set demande
     *
     * @param integer $demande
     *
     * @return LigneDemande
     */
    public function setDemande($demande)
    {
        $this->demande = $demande;

        return $this;
    }

    /**
     * Get demande
     *
     * @return int
     */
    public function getDemande()
    {
        return $this->demande;
    }

    /**
     * Set produit
     *
     * @param integer $produit
     *
     * @return LigneDemande
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
     * @return LigneDemande
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
     * Set montantEstime
     *
     * @param float $montantEstime
     *
     * @return LigneDemande
     */
    public function setMontantEstime($montantEstime)
    {
        $this->montantEstime = $montantEstime;

        return $this;
    }

    /**
     * Get montantEstime
     *
     * @return float
     */
    public function getMontantEstime()
    {
        return $this->montantEstime;
    }
}
