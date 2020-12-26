<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EtatDemande
 *
 * @ORM\Table(name="etat_demande")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\EtatDemandeRepository")
 */
class EtatDemande
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
     * @ORM\Column(name="libelle", type="string", length=200, nullable=true)
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="DemandeHasEtatDemande", mappedBy="etatDemande", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $demandes;    

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
     * Constructor
     */
    public function __construct()
    {
        $this->demandes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return EtatDemande
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
     * Add demande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande $demande
     *
     * @return EtatDemande
     */
    public function addDemande(\gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande $demande)
    {
        $this->demandes[] = $demande;

        return $this;
    }

    /**
     * Remove demande
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande $demande
     */
    public function removeDemande(\gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande $demande)
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
}
