<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Renouvellement
 *
 * @ORM\Table(name="renouvellement")
 * @ORM\Entity(repositoryClass="gestion\achatsFondDeRoulementBundle\Repository\RenouvellementRepository")
 */
class Renouvellement
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
     * @var decimal
     *
     * @ORM\Column(name="numero", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $numero;
   

      /**
     * @var string
     *
     * @ORM\Column(name="date_renouvellement", type="date", length=255)
     */
    private $date_renouvellement;

    /**
     * @ORM\OneToMany(targetEntity="Achat", mappedBy="renouvellement", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $achats;

    /**
     * @ORM\OneToMany(targetEntity="RenouvellementHasEtatRenouvellement", mappedBy="renouvellement", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $etatsRenouvellements;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->achats = new \Doctrine\Common\Collections\ArrayCollection();
        $this->etatsRenouvellements = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Renouvellement
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
     * Set dateRenouvellement
     *
     * @param \DateTime $dateRenouvellement
     *
     * @return Renouvellement
     */
    public function setDateRenouvellement($dateRenouvellement)
    {
        $this->date_renouvellement = $dateRenouvellement;

        return $this;
    }

    /**
     * Get dateRenouvellement
     *
     * @return \DateTime
     */
    public function getDateRenouvellement()
    {
        return $this->date_renouvellement;
    }

    /**
     * Add achat
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Achat $achat
     *
     * @return Renouvellement
     */
    public function addAchat(\gestion\achatsFondDeRoulementBundle\Entity\Achat $achat)
    {
        $this->achats[] = $achat;

        return $this;
    }

    /**
     * Remove achat
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Achat $achat
     */
    public function removeAchat(\gestion\achatsFondDeRoulementBundle\Entity\Achat $achat)
    {
        $this->achats->removeElement($achat);
    }

    /**
     * Get achats
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAchats()
    {
        return $this->achats;
    }

    /**
     * Add etatsRenouvellement
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement $etatsRenouvellement
     *
     * @return Renouvellement
     */
    public function addEtatsRenouvellement(\gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement $etatsRenouvellement)
    {
        $this->etatsRenouvellements[] = $etatsRenouvellement;

        return $this;
    }

    /**
     * Remove etatsRenouvellement
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement $etatsRenouvellement
     */
    public function removeEtatsRenouvellement(\gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement $etatsRenouvellement)
    {
        $this->etatsRenouvellements->removeElement($etatsRenouvellement);
    }

    /**
     * Get etatsRenouvellements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEtatsRenouvellements()
    {
        return $this->etatsRenouvellements;
    }
}
