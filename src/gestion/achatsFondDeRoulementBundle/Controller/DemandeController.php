<?php

namespace gestion\achatsFondDeRoulementBundle\Controller;

use gestion\achatsFondDeRoulementBundle\Entity\Demande;
use gestion\achatsFondDeRoulementBundle\Entity\LigneDemande;
use gestion\achatsFondDeRoulementBundle\Entity\DemandeHasEtatDemande;
use gestion\achatsFondDeRoulementBundle\Form\DemandeType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Response;

/**
 * Demande controller.
 *
 * @Route("demande")
 */
class DemandeController extends Controller
{
    /**
     * Lists all demande entities.
     *
     * @Route("/", name="demande_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 10),
                array("fonctionnalite"=>"lister", "id"=> 9),
                array("fonctionnalite"=>"modifier", "id"=> 11),
                array("fonctionnalite"=>"supprimer", "id"=> 12),

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

        $em = $this->getDoctrine()->getManager();

        // if($user->getUnite()->getParent()){
        //     $crb_connecte = $em->getRepository('gestionachatsFondDeRoulementBundle:Unite')->find($user->getUnite()->getParent());
        // }else{
        //     $crb_connecte = $user->getUnite();
        // }
        $crb_connecte = $user->getCrb();

        $demandes = $this->get("service.custom")->getDemandeByCrb($crb_connecte);

        return $this->render('demande/index.html.twig', array(
            'demandes' => $demandes,
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
        //return new Response('');
    }

    /**
     * Creates a new demande entity.
     *
     * @Route("/new", name="demande_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 10),
                array("fonctionnalite"=>"lister", "id"=> 9),
                array("fonctionnalite"=>"modifier", "id"=> 11),
                array("fonctionnalite"=>"supprimer", "id"=> 12),

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

        $ligneDemande = new LigneDemande();
        $ligneDemande->setQte(1);
        $ligneDemande->setProduit(null);

        $demande = new Demande();
        $demande->setUnite($user->getUnite());
        $demande->getLignesDemandes()->add($ligneDemande);

        $form = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\DemandeType', $demande);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            

            //  trace de l'etape de création
            $etatDemande = new DemandeHasEtatDemande();
            $etat = $em->getRepository('gestionachatsFondDeRoulementBundle:EtatDemande')->find(1); 
            $etatDemande->setEtatDemande($etat);
            $etatDemande->setDemande($demande);
            $etatDemande->setDateEtat(new \DateTime());
            $demande->addEtatsDemande($etatDemande);

            foreach ($demande->getLignesDemandes() as $ligne) {
                $ligne->setDemande($demande);
            }

            $data = $form->getData();
            $demande->setDateDemande(new \DateTime($data->getDateDemande()));

            $em->persist($demande);
            $em->flush($demande);

            return $this->redirectToRoute('demande_index');
        }
        return $this->render('demande/new.html.twig', array(
            'demande' => $demande,
            'form' => $form->createView(),
            'demande' => $demande,
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }


    /**
     * Finds and displays a demande entity.
     *
     * @Route("/valider/{id}", name="demande_valider")
     * @Method("GET")
     */
    public function validerAction(Demande $demande)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 10),
                array("fonctionnalite"=>"lister", "id"=> 9),
                array("fonctionnalite"=>"modifier", "id"=> 11),
                array("fonctionnalite"=>"supprimer", "id"=> 12),
                array("fonctionnalite"=>"valider", "id"=> 17),
                array("fonctionnalite"=>"refuser", "id"=> 18),

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

        $em = $this->getDoctrine()->getManager();    

        $etatDemande = new DemandeHasEtatDemande();
        $etat = $em->getRepository('gestionachatsFondDeRoulementBundle:EtatDemande')->find(2); 
        $etatDemande->setEtatDemande($etat);
        $etatDemande->setDemande($demande);
        $etatDemande->setDateEtat(new \DateTime());

        $demande->addEtatsDemande($etatDemande);

        $em->persist($demande);
        $em->flush($demande);

        $deleteForm = $this->createDeleteForm($demande);

        return $this->render('demande/show.html.twig', array(
            'demande' => $demande,
            'delete_form' => $deleteForm->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Finds and displays a demande entity.
     *
     * @Route("/refuser/{id}", name="demande_refuser")
     * @Method("GET")
     */
    public function refuserAction(Demande $demande)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 10),
                array("fonctionnalite"=>"lister", "id"=> 9),
                array("fonctionnalite"=>"modifier", "id"=> 11),
                array("fonctionnalite"=>"supprimer", "id"=> 12),
                array("fonctionnalite"=>"valider", "id"=> 17),
                array("fonctionnalite"=>"refuser", "id"=> 18),

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

        $em = $this->getDoctrine()->getManager();    

        $etatDemande = new DemandeHasEtatDemande();
        $etat = $em->getRepository('gestionachatsFondDeRoulementBundle:EtatDemande')->find(5); 
        $etatDemande->setEtatDemande($etat);
        $etatDemande->setDemande($demande);
        $etatDemande->setDateEtat(new \DateTime());

        $demande->addEtatsDemande($etatDemande);

        $em->persist($demande);
        $em->flush($demande);

        $deleteForm = $this->createDeleteForm($demande);

        return $this->render('demande/show.html.twig', array(
            'demande' => $demande,
            'delete_form' => $deleteForm->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Finds and displays a demande entity.
     *
     * @Route("/{id}", name="demande_show")
     * @Method("GET")
     */
    public function showAction(Demande $demande)
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 10),
                array("fonctionnalite"=>"lister", "id"=> 9),
                array("fonctionnalite"=>"modifier", "id"=> 11),
                array("fonctionnalite"=>"supprimer", "id"=> 12),
                array("fonctionnalite"=>"valider", "id"=> 17),
                array("fonctionnalite"=>"refuser", "id"=> 18),

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

        $deleteForm = $this->createDeleteForm($demande);

        return $this->render('demande/show.html.twig', array(
            'demande' => $demande,
            'delete_form' => $deleteForm->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Displays a form to edit an existing demande entity.
     *
     * @Route("/{id}/edit", name="demande_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Demande $demande)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 10),
                array("fonctionnalite"=>"lister", "id"=> 9),
                array("fonctionnalite"=>"modifier", "id"=> 11),
                array("fonctionnalite"=>"supprimer", "id"=> 12),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5),
                array("fonctionnalite"=>"renouvellement", "id"=> 20)
            ));
            
            if($droitsMenuPrincipal["modifier"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $deleteForm = $this->createDeleteForm($demande);

        $editForm = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\DemandeEditType', $demande);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('demande_show', array('id' => $demande->getId()));
        }

        return $this->render('demande/edit.html.twig', array(
            'demande' => $demande,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Deletes a demande entity.
     *
     * @Route("/{id}/delete", name="demande_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Demande $demande)
    {
        $form = $this->createDeleteForm($demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($demande);
            $em->flush();
        }

        return $this->redirectToRoute('demande_index');
    }

    /**
     * Creates a form to delete a demande entity.
     *
     * @param Demande $demande The demande entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Demande $demande)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('demande_delete', array('id' => $demande->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
