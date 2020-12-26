<?php

namespace administrationBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="fos_user")
 * @ORM\Entity(repositoryClass="administrationBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Profil
     *
     * @ORM\ManyToOne(targetEntity="Profil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profil_id", referencedColumnName="id")
     * })
     */
    private $profil;    

    /**
     * @var gestion\achatsFondDeRoulementBundle\Entity\Unite
     *
     * @ORM\ManyToOne(targetEntity="gestion\achatsFondDeRoulementBundle\Entity\Unite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="crb_id", referencedColumnName="id")
     * })
     */
    private $crb;    

    /**
     * @var gestion\achatsFondDeRoulementBundle\Entity\Unite
     *
     * @ORM\ManyToOne(targetEntity="gestion\achatsFondDeRoulementBundle\Entity\Unite")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="unite_id", referencedColumnName="id")
     * })
     */
    private $unite;    

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * Set profil
     *
     * @param \administrationBundle\Entity\Profil $profil
     *
     * @return User
     */
    public function setProfil(\administrationBundle\Entity\Profil $profil = null)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return \administrationBundle\Entity\Profil
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return User
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set crb
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Unite $crb
     *
     * @return User
     */
    public function setCrb(\gestion\achatsFondDeRoulementBundle\Entity\Unite $crb = null)
    {
        $this->crb = $crb;

        return $this;
    }

    /**
     * Get crb
     *
     * @return \gestion\achatsFondDeRoulementBundle\Entity\Unite
     */
    public function getCrb()
    {
        return $this->crb;
    }

    /**
     * Set unite
     *
     * @param \gestion\achatsFondDeRoulementBundle\Entity\Unite $unite
     *
     * @return User
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
}
