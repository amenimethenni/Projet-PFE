<?php

namespace gestion\achatsFondDeRoulementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TauxTva
 *
 * @ORM\Table(name="taux_tva")
 * @ORM\Entity
 */
class TauxTva
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="taux", type="float", precision=10, scale=0, nullable=false)
     */
    private $taux;



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
     * Set taux
     *
     * @param float $taux
     *
     * @return TauxTva
     */
    public function setTaux($taux)
    {
        $this->taux = $taux;

        return $this;
    }

    /**
     * Get taux
     *
     * @return float
     */
    public function getTaux()
    {
        return $this->taux;
    }
}
