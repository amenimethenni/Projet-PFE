<?php
namespace gestion\achatsFondDeRoulementBundle\Services;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use gestion\achatsFondDeRoulementBundle\Entity\Produit;
use Doctrine\ORM\EntityManager;

Class CustomService{

	public $em;

	public function __construct(EntityManager $em) {
		$this->em = $em;
	}

	public function in_array_multidimentionel($produit,$qte,$tableau) {

        foreach ($tableau as $key => $data) {

		    if ($data['produit']->getId() == $produit) {
		        return $key; 
		    }

		}
		return -1;

    }

    public function getDemandeByCrb($crb) {

    	$resultat = array();
        
        $demandes = $this->em->getRepository('gestionachatsFondDeRoulementBundle:Demande')->findAll();

        foreach ($demandes as $key => $demande) {
    
            if($this->getCrb($demande->getUnite())==$crb){        	
            	$etats = array();
    	        foreach ($demande->getEtatsDemandes() as $key2 => $etat) {
    	        	$etats[$key2] = $etat->getEtatDemande();
    	        }
    	        $etatsInversed = array_reverse($etats);

            	$demande_temp = array(
            		'id' => $demande->getId(),
            		'dateDemande' => $demande->getDateDemande(),
            		'unite' => $demande->getUnite(),
            		'fichierBcn' => $demande->getFichierBcn(),
            		'lienBcn' => $demande->getLienBcn(),
            		'numeroBcn' => $demande->getNumeroBcn(),
            		'uniteDemandeuse' => $demande->getUniteDemandeuse(),
            		'lignesDemandes' => $demande->getLignesDemandes(),
            		'etatsDemandes' => $etatsInversed
            	);        
    	        
    	        $resultat[] = $demande_temp;
            }

        }
        return $resultat;
    }

    public function getCrb($unite) {
        if($unite->getParent())
            return $this->em->getRepository('gestionachatsFondDeRoulementBundle:Unite')->find($unite->getParent());
        else
            return $this->em->getRepository('gestionachatsFondDeRoulementBundle:Unite')->find($unite->getId());        
    }

    public function calculerTotal($facture_id)
    {
        $facture = $this->em->getRepository('gestionachatsFondDeRoulementBundle:Facture')->find($facture_id);
        $lignesFacture = $this->em->getRepository('gestionachatsFondDeRoulementBundle:LigneFacture')->findBy(array('facture'=>$facture));
        $total = 0;
        foreach ($lignesFacture as $key => $lignefacture){
            $ht = $lignefacture->getPrixHt()-$lignefacture->getRemise();
            $tva = $ht*($lignefacture->getTauxTva()->getTaux()/100);
            $total += ($ht+$tva)*$lignefacture->getQte();   
        }
        return $total;
        
    }
    
    public function Calculnombreproduit($achat_id)
      {  

        $demandes = $this->em->getRepository('gestionachatsFondDeRoulementBundle:Demande')->findBy(array('achat'=>$achat_id));
        $nbr = 0;
        foreach ($demandes as $key => $demande) {
            $nbr += count($this->em->getRepository('gestionachatsFondDeRoulementBundle:LigneDemande')->findBy(array('demande'=>$demande->getId())));
        }       
        return $nbr;
    }
}