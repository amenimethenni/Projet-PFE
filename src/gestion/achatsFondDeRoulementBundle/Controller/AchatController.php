<?php

namespace gestion\achatsFondDeRoulementBundle\Controller;

use gestion\achatsFondDeRoulementBundle\Form\AchatRechercheType;
use gestion\achatsFondDeRoulementBundle\Entity\Demande;
use gestion\achatsFondDeRoulementBundle\Entity\Facture;
use gestion\achatsFondDeRoulementBundle\Entity\Achat;
use gestion\achatsFondDeRoulementBundle\Entity\LigneDemande;
use gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande;
use gestion\achatsFondDeRoulementBundle\Entity\LigneDevis;
use gestion\achatsFondDeRoulementBundle\Entity\LigneFacture;
use gestion\achatsFondDeRoulementBundle\Entity\Devis;
use gestion\achatsFondDeRoulementBundle\Form\DemandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gestion\achatsFondDeRoulementBundle\Services\CustomService;
use gestion\achatsFondDeRoulementBundle\Form\DevisType;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;

/**
 * Demande controller.
 *
 * @Route("achat")
 */
class AchatController extends Controller
{
    /**
     * Lists all demande entities.
     *
     * @Route("/", name="achat_index")
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"lister", "id"=> 13),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5),
                array("fonctionnalite"=>"renouvellement", "id"=> 20)
            ));
            
            if($droitsMenuPrincipal["lister"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }
        
        //  initialisation du formulaire de recherche    
        $form = $this->createForm(AchatRechercheType::class);
        $form->handleRequest($request);

        $criteres = array();
        
        if(isset($request->request->get('gestionachatsFondDeRoulement_achat')["dateDe"]) and $request->request->get('gestionachatsFondDeRoulement_achat')["dateDe"]!=""){
            $dateDebut = new \DateTime($request->request->get('gestionachatsFondDeRoulement_achat')["dateDe"]);
            array_push($criteres, "a.dateAchat >= '".$dateDebut->format('Y-m-d')."'");
        }elseif(!isset($request->request->get('gestionachatsFondDeRoulement_achat')["dateDe"])){
            $dateDebut = new \DateTime('first day of this month');
            array_push($criteres, "a.dateAchat >= '".$dateDebut->format('Y-m-d')."'");
        }   
        
        
        if(isset($request->request->get('gestionachatsFondDeRoulement_achat')["dateA"]) and $request->request->get('gestionachatsFondDeRoulement_achat')["dateA"]!=""){
            $dateFin = new \DateTime($request->request->get('gestionachatsFondDeRoulement_achat')["dateA"]);
            array_push($criteres, "a.dateAchat <= '".$dateFin->format('Y-m-d')."'");
        }elseif(!isset($request->request->get('gestionachatsFondDeRoulement_achat')["dateA"])){
            $dateFin = new \DateTime();
            array_push($criteres, "a.dateAchat <= '".$dateFin->format('Y-m-d')."'");
        }   

        if(isset($request->request->get('gestionachatsFondDeRoulement_achat')["factured"]) and 
           !isset($request->request->get('gestionachatsFondDeRoulement_achat')["notFactured"])){
            array_push($criteres, "a.facture is not null");
        }else if(!isset($request->request->get('gestionachatsFondDeRoulement_achat')["factured"]) and isset($request->request->get('gestionachatsFondDeRoulement_achat')["notFactured"])){
            array_push($criteres, "a.facture is null");
        }  

        if(isset($request->request->get('gestionachatsFondDeRoulement_achat')["renouvele"]) and 
           !isset($request->request->get('gestionachatsFondDeRoulement_achat')["nonRenouvle"])){
            array_push($criteres, "a.renouvellement is not null");
        }else if(!isset($request->request->get('gestionachatsFondDeRoulement_achat')["renouvele"]) and isset($request->request->get('gestionachatsFondDeRoulement_achat')["nonRenouvle"])){
            array_push($criteres, "a.renouvellement is null");
        }      
        
        $em = $this->getDoctrine()->getManager();
        $achats = $em->getRepository('gestionachatsFondDeRoulementBundle:Achat')->rechercherAchats($criteres);

        $listeAchats = array();
        foreach ($achats as $key => $achat) {
            if($achat->getFacture()){
                $total = $this->get("service.custom")->calculerTotal($achat->getFacture()->getId());
                $listeAchats[] = array(
                    "achat" => $achat,
                    "total" => $total
                );
            }else{
                $listeAchats[] = array(
                    "achat" => $achat,
                    "total" => 0
                );
            }
            
        }
        
        return $this->render('achat/index.html.twig', array(
            'achats' => $listeAchats,
            'recherche' => $form->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Lists all demande entities.
     *
     * @Route("/formulaire", name="achat_formulaire")
     * @Method("POST")
     */
    public function formulaireAjoutAction(Request $request)
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 14),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5),
                array("fonctionnalite"=>"renouvellement", "id"=> 20)
            ));
            
            if($droitsMenuPrincipal["ajouter"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $em = $this->getDoctrine()->getManager();
        $produits = array(); 
        
        $achat = new Achat();

        $demandes = array();
        foreach ($request->request as $key => $value) {
            if(substr($key,0,5)=='check'){
                
                $demande_id = $value;

                $demande = $em->getRepository('gestionachatsFondDeRoulementBundle:Demande')->find($demande_id);
                 
                $demandes[] = $demande;    

                $achat->addDemande($demande);

                $LignesDemande = $em->getRepository('gestionachatsFondDeRoulementBundle:LigneDemande')->findBy(array('demande'=>$demande_id));
                foreach ($LignesDemande as $key2 => $ligneDemande) {
                    $index = $this->get("service.custom")->in_array_multidimentionel($ligneDemande->getProduit()->getId(),$ligneDemande->getQte(),$produits);
                    if($index==-1){
                        array_push($produits, array(
                            'produit'=>$ligneDemande->getProduit(),
                            'qte'=>$ligneDemande->getQte()
                        ));
                    }else{
                        $produits[$index]['qte']+=$ligneDemande->getQte();
                    }
                }
            }
        }           

        //  1er devis
        $devis1 = new Devis();     
        $devis2 = new Devis();
        $devis3 = new Devis();  
        $devis4 = new Devis();  
        
        $facture = new Facture();

        foreach ($produits as $key => $ligne) {
            $ligneDevis1 = new LigneDevis();
            $ligneDevis1->setQte($ligne["qte"]);
            $ligneDevis1->setPrixHt(0);
            $ligneDevis1->setRemise(0);
            $ligneDevis1->setProduit($ligne["produit"]);
            $ligneDevis1->setTauxTva(null);
            $devis1->getLignesDevis()->add($ligneDevis1);

            $ligneDevis2 = new LigneDevis();
            $ligneDevis2->setQte($ligne["qte"]);
            $ligneDevis2->setPrixHt(0);
            $ligneDevis2->setRemise(0);
            $ligneDevis2->setProduit($ligne["produit"]);
            $ligneDevis2->setTauxTva(null);
            $devis2->getLignesDevis()->add($ligneDevis2);

            $ligneDevis3 = new LigneDevis();
            $ligneDevis3->setQte($ligne["qte"]);
            $ligneDevis3->setPrixHt(0);
            $ligneDevis3->setRemise(0);
            $ligneDevis3->setProduit($ligne["produit"]);
            $ligneDevis3->setTauxTva(null);
            $devis3->getLignesDevis()->add($ligneDevis3);

            $ligneFacture = new LigneFacture();
            $ligneFacture->setQte($ligne["qte"]);
            $ligneFacture->setPrixHt(0);
            $ligneFacture->setRemise(0);
            $ligneFacture->setProduit($ligne["produit"]);
            $ligneFacture->setTauxTva(null);
            $facture->getLignesFactures()->add($ligneFacture);
        }
        
        $achat->getDeviss()->add($devis1);
        $achat->getDeviss()->add($devis2);
        $achat->getDeviss()->add($devis3);

        $achat->setFacture($facture);

        $achatDevisForm = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\AchatType', $achat);
        $achatFactureForm = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\AchatType', $achat);

        return $this->render('achat/formulaire.html.twig', array(
            'produits' => $produits,
            'formsDevis' => $achatDevisForm->createView(),
            'formsFacture' => $achatFactureForm->createView(),
            'demandes' => $demandes,
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));

    }

    /**
     * Lists all demande entities.
     *
     * @Route("/newDevis", name="achat_new_devis")
     * @Method("POST")
     */
    public function addDevisAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 14),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5),
                array("fonctionnalite"=>"renouvellement", "id"=> 20)
            ));
            
            if($droitsMenuPrincipal["ajouter"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $em = $this->getDoctrine()->getManager();
        $produits = array(); 

        $achat = new Achat();

        foreach ($request->request as $key => $value) {
            
            if(substr($key,0,7)=='demande'){                
                $demande_id = $value;
                $demande = $em->getRepository('gestionachatsFondDeRoulementBundle:Demande')->find($demande_id);                
                $achat->addDemande($demande);   
            }
        }           

        //  1er devis
        $devis1 = new Devis();     
        $devis2 = new Devis();
        $devis3 = new Devis(); 
        
        foreach ($produits as $key => $ligne) {
            $ligneDevis1 = new LigneDevis();
            $ligneDevis1->setQte($ligne["qte"]);
            $ligneDevis1->setPrixHt(null);
            $ligneDevis1->setRemise(0);
            $ligneDevis1->setProduit($ligne["produit"]);
            $ligneDevis1->setTauxTva(null);
            $devis1->getLignesDevis()->add($ligneDevis1);

            $ligneDevis2 = new LigneDevis();
            $ligneDevis2->setQte($ligne["qte"]);
            $ligneDevis2->setPrixHt(null);
            $ligneDevis2->setRemise(0);
            $ligneDevis2->setProduit($ligne["produit"]);
            $ligneDevis2->setTauxTva(null);
            $devis2->getLignesDevis()->add($ligneDevis2);

            $ligneDevis3 = new LigneDevis();
            $ligneDevis3->setQte($ligne["qte"]);
            $ligneDevis3->setPrixHt(null);
            $ligneDevis3->setRemise(0);
            $ligneDevis3->setProduit($ligne["produit"]);
            $ligneDevis3->setTauxTva(null);
            $devis3->getLignesDevis()->add($ligneDevis3);
        }
        
        $achat->getDeviss()->add($devis1);
        $achat->getDeviss()->add($devis2);
        $achat->getDeviss()->add($devis3);
        
        $achatForm = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\AchatType', $achat);

        $achatForm->handleRequest($request);

        if ($achatForm->isSubmitted() && $achatForm->isValid()) {
            
            foreach ($achat->getDeviss() as $devis) {
                $devis->setAchat($achat);
            }

            foreach ($achat->getDemandes() as $demande) {

                //  trace de l'etape d'achat
                $etatDemande = new DemandeHasEtatDemande();
                $etat = $em->getRepository('gestionachatsFondDeRoulementBundle:EtatDemande')->find(6); 
                $etatDemande->setEtatDemande($etat);
                $etatDemande->setDemande($demande);
                $etatDemande->setDateEtat(new \DateTime());
                $demande->addEtatsDemande($etatDemande);

                $demande->setAchat($achat);
                
                // echo "Demande = ".$demande->getId()."-";
                // echo "Achat = ".$demande->getAchat()->getDemandes()[0]->getId()."<br>";    
            }
            
            $achat->setDateAchat(new \DateTime());
            $achat->setFacture(null);

            $em->persist($achat);            
            $em->flush($achat);

            // return NEW Response('');
            return $this->redirectToRoute('achat_index');
        }
        
        
        return $this->render('achat/formulaire.html.twig', array(
            'produits' => $produits,
            'formsDevis' => $achatForm->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));

    }

    /**
     * Lists all demande entities.
     *
     * @Route("/newFacture", name="achat_new_facture")
     * @Method("POST")
     */
    public function addFactureAction(Request $request)
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 14),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5),
                array("fonctionnalite"=>"renouvellement", "id"=> 20)
            ));
            
            if($droitsMenuPrincipal["ajouter"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $em = $this->getDoctrine()->getManager();
        $produits = array(); 

        $achat = new Achat();

        foreach ($request->request as $key => $value) {
            
            if(substr($key,0,7)=='demande'){                
                $demande_id = $value;
                $demande = $em->getRepository('gestionachatsFondDeRoulementBundle:Demande')->find($demande_id);                
                $achat->addDemande($demande);   
            }
        }           

        $facture = new Facture();
        
        //  1er devis
        $devis1 = new Devis();     
        $devis2 = new Devis();
        $devis3 = new Devis(); 
        
        foreach ($produits as $key => $ligne) {
            $ligneDevis1 = new LigneDevis();
            $ligneDevis1->setQte($ligne["qte"]);
            $ligneDevis1->setPrixHt(null);
            $ligneDevis1->setRemise(0);
            $ligneDevis1->setProduit($ligne["produit"]);
            $ligneDevis1->setTauxTva(null);
            $devis1->getLignesDevis()->add($ligneDevis1);

            $ligneDevis2 = new LigneDevis();
            $ligneDevis2->setQte($ligne["qte"]);
            $ligneDevis2->setPrixHt(null);
            $ligneDevis2->setRemise(0);
            $ligneDevis2->setProduit($ligne["produit"]);
            $ligneDevis2->setTauxTva(null);
            $devis2->getLignesDevis()->add($ligneDevis2);

            $ligneDevis3 = new LigneDevis();
            $ligneDevis3->setQte($ligne["qte"]);
            $ligneDevis3->setPrixHt(null);
            $ligneDevis3->setRemise(0);
            $ligneDevis3->setProduit($ligne["produit"]);
            $ligneDevis3->setTauxTva(null);
            $devis3->getLignesDevis()->add($ligneDevis3);

            $ligneFacture = new LigneFacture();
            $ligneFacture->setQte($ligne["qte"]);
            $ligneFacture->setPrixHt(0);
            $ligneFacture->setRemise(0);
            $ligneFacture->setProduit($ligne["produit"]);
            $ligneFacture->setTauxTva(null);
            $facture->getLignesFactures()->add($ligneFacture);
            echo "*".$ligne["produit"]."<br>";
        }

        $achat->getDeviss()->add($devis1);
        $achat->getDeviss()->add($devis2);
        $achat->getDeviss()->add($devis3);
        
        $achat->setFacture($facture);
        
        $achatForm = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\AchatType', $achat);

        $achatForm->handleRequest($request);

        if ($achatForm->isSubmitted() && $achatForm->isValid()) {
            
            foreach ($achat->getDeviss() as $devis) {
                $devis->setAchat($achat);
            }

            foreach ($achat->getDemandes() as $demande) {

                //  trace de l'etape d'achat
                $etatDemande = new DemandeHasEtatDemande();
                $etat = $em->getRepository('gestionachatsFondDeRoulementBundle:EtatDemande')->find(6); 
                $etatDemande->setEtatDemande($etat);
                $etatDemande->setDemande($demande);
                $etatDemande->setDateEtat(new \DateTime());
                $demande->addEtatsDemande($etatDemande);

                $demande->setAchat($achat);
                
                // echo "Demande = ".$demande->getId()."-";
                // echo "Achat = ".$demande->getAchat()->getDemandes()[0]->getId()."<br>";    
            }

            foreach ($facture->getLignesFactures() as $ligne) {
                $ligne->setFacture($facture);
            }

            $data = $achatForm->getData();
            $facture->setDateFacture(new \DateTime($data->getFacture()->getDateFacture()));
            $achat->setDateAchat(new \DateTime());

            $em->persist($achat);            
            $em->flush($achat);

            // return NEW Response('ok');
            return $this->redirectToRoute('achat_index');
        }
        

        return $this->render('achat/formulaire.html.twig', array(
            'produits' => $produits,
            'formsDevis' => $achatForm->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));

    }

    /**
     * Lists all demande entities.
     *
     * @Route("/{id}", name="achat_show")
     * @Method("GET")
     */
    public function showAction(Achat $achat)
    {
          $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 14),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5),
                array("fonctionnalite"=>"renouvellement", "id"=> 20)
            ));
            
            if($droitsMenuPrincipal["ajouter"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }      

        $em = $this->getDoctrine()->getManager();
        $demandes = $em->getRepository('gestionachatsFondDeRoulementBundle:Demande')->findBy(array(
                "achat" => $achat->getId()
            ));
        $deviss= $em->getRepository('gestionachatsFondDeRoulementBundle:Devis')->findBy(array(
            "achat" => $achat->getId()
        ));
        $facture = $achat->getFacture();

        return $this->render('achat/show.html.twig', array(
            'achat' => $achat, 
            'demandes'=>$demandes, 
            'deviss' => $deviss,   
            'factures'=>$facture,      
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }    

    /**
     * Lists all demande entities.
     *
     * @Route("/facture/{id}", name="achat_facture_show")
     * @Method("GET")
     */
    public function formulaireAjoutFactureAction(Achat $achat)
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 14),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5),
                array("fonctionnalite"=>"renouvellement", "id"=> 20)
            ));
            
            if($droitsMenuPrincipal["ajouter"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $em = $this->getDoctrine()->getManager();
        $produits = array(); 
        
        $demandes = $em->getRepository('gestionachatsFondDeRoulementBundle:Demande')->findBy(array("achat",$achat->getId()));

        foreach ($demandes as $key => $demande) {
                                
            $LignesDemande = $em->getRepository('gestionachatsFondDeRoulementBundle:LigneDemande')->findBy(array('demande'=>$demande->getId()));
            foreach ($LignesDemande as $key2 => $ligneDemande) {
                $index = $this->get("service.custom")->in_array_multidimentionel($ligneDemande->getProduit()->getId(),$ligneDemande->getQte(),$produits);
                if($index==-1){
                    array_push($produits, array(
                        'produit'=>$ligneDemande->getProduit(),
                        'qte'=>$ligneDemande->getQte()
                    ));
                }else{
                    $produits[$index]['qte']+=$ligneDemande->getQte();
                }
            }

        }           

var_dump($produits);

return new Response();
    }

}
