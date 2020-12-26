<?php
namespace administrationBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use gestion\achatsFondDeRoulementBundle\Entity\Produit;
use Doctrine\ORM\EntityManager;

Class AccessService{

	public $em;

	public function __construct(EntityManager $em) {
		$this->em = $em;
	}

	public function checkMainMenuAccess($profil_id,$access) {

        $droit = array();

        foreach ($access as $key => $value) {
            $droit[$value["fonctionnalite"]] = count($this->em->getRepository('administrationBundle:Profil')->findFonctionnaliesByProfil($profil_id,$value["id"]) ); 
        }

        return $droit;

    }

}