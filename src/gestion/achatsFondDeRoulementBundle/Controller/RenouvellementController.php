<?php

namespace gestion\achatsFondDeRoulementBundle\Controller;

use gestion\achatsFondDeRoulementBundle\Entity\Renouvellement;
use gestion\achatsFondDeRoulementBundle\Entity\RenouvellementHasEtatRenouvellement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;

/**
 * Renouvellement controller.
 *
 * @Route("renouvellement")
 */
class RenouvellementController extends Controller
{
    /**
     * Lists all renouvellement entities.
     *
     * @Route("/", name="renouvellement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"lister", "id"=> 20),

                array("fonctionnalite"=>"renouvellement", "id"=> 20),
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

        $renouvellements = $em->getRepository('gestionachatsFondDeRoulementBundle:Renouvellement')->findAll();
        
        return $this->render('renouvellement/index.html.twig', array(
            'renouvellements' => $renouvellements,
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Creates a new renouvellement entity.
     *
     * @Route("/new", name="renouvellement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $renouvellement = new renouvellement();
        $renouvellement->setDateRenouvellement(new \Datetime());

        foreach ($request->request as $key => $value) {
            if(substr($key,0,5)=='check'){
                $achat = $em->getRepository('gestionachatsFondDeRoulementBundle:Achat')->find($value);
                $renouvellement->getAchats()->add($achat);            
            }
        }

        foreach ($renouvellement->getAchats() as $ligne) {
            $ligne->setRenouvellement($renouvellement);
        }

        $etatRenouvellement = new RenouvellementHasEtatRenouvellement();
        $etatRenouvellement->setDateEtat(new \Datetime());
        $etatRenouvellement->setRenouvellement($renouvellement);
        $etat = $em->getRepository('gestionachatsFondDeRoulementBundle:EtatRenouvellement')->find(1);
        $etatRenouvellement->setEtatRenouvellement($etat);
        $renouvellement-> addEtatsRenouvellement($etatRenouvellement);
        
        $em->persist($renouvellement);
        $em->flush($renouvellement);

        $renouvellements = $em->getRepository('gestionachatsFondDeRoulementBundle:Renouvellement')->findAll();

        // return new Response('');
        return $this->render('renouvellement/index.html.twig', array(
          'renouvellements' => $renouvellements
         ));
    }
    /**
     * Finds and displays a demande entity.
     *
     * @Route("/valider/{id}", name="renouvellement_valider")
     * @Method("GET")
     */
    public function validerAction(Renouvellement $renouvellement)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 19),
                array("fonctionnalite"=>"lister", "id"=> 20),
                array("fonctionnalite"=>"modifier", "id"=> 21),
                array("fonctionnalite"=>"supprimer", "id"=> 22),
                array("fonctionnalite"=>"valider", "id"=> 23),
                array("fonctionnalite"=>"refuser", "id"=> 24),

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

        $etatRenouvellement = new RenouvellementHasEtatRenouvellement();
        $etat = $em->getRepository('gestionachatsFondDeRoulementBundle:EtatRenouvellement')->find(2); 
        $etatRenouvellement->setetatRenouvellement($etat);
        $etatRenouvellement->setRenouvellement($renouvellement);
        $etatRenouvellement->setDateEtat(new \DateTime());

        $renouvellement->addEtatsRenouvellement($etatRenouvellement);

        $em->persist($renouvellement);
        $em->flush($renouvellement);
        return $this->redirectToRoute('renouvellement_index');

        // $deleteForm = $this->createDeleteForm($renouvellement);

        // return $this->render('renouvellement/show.html.twig', array(
        //     'renouvellement' => $renouvellement,
        //     'delete_form' => $deleteForm->createView(),
        //     'droitsMenuPrincipal' => $droitsMenuPrincipal
        // ));
    }
     /**
     * Finds and displays a demande entity.
     *
     * @Route("/refuser/{id}", name="renouvellement_refuser")
     * @Method("GET")
     */
    public function refuserAction(Renouvellement $renouvellement)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 19),
                array("fonctionnalite"=>"lister", "id"=> 20),
                array("fonctionnalite"=>"modifier", "id"=> 21),
                array("fonctionnalite"=>"supprimer", "id"=> 22),
                array("fonctionnalite"=>"valider", "id"=> 23),
                array("fonctionnalite"=>"refuser", "id"=> 24),

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

        $etatRenouvellement = new RenouvellementHasEtatRenouvellement();
        $etat = $em->getRepository('gestionachatsFondDeRoulementBundle:EtatRenouvellement')->find(4); 
        $etatRenouvellement->setetatRenouvellement($etat);
        $etatRenouvellement->setRenouvellement($renouvellement);
        $etatRenouvellement->setDateEtat(new \DateTime());

        $renouvellement->addEtatsRenouvellement($etatRenouvellement);

        $em->persist($renouvellement);
        $em->flush($renouvellement);
        return $this->redirectToRoute('renouvellement_index');

        // $deleteForm = $this->createDeleteForm($renouvellement);

        // return $this->render('renouvellement/show.html.twig', array(
        //     'renouvellement' => $renouvellement,
        //     'delete_form' => $deleteForm->createView(),
        //     'droitsMenuPrincipal' => $droitsMenuPrincipal
        // ));
    }



    /**
     * Finds and displays a renouvellement entity.
     *
     * @Route("/{id}", name="renouvellement_show")
     * @Method("GET")
     */

    public function showAction(Renouvellement $renouvellement)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"lister", "id"=> 20),
                array("fonctionnalite"=>"valider", "id"=> 23),
                array("fonctionnalite"=>"refuser", "id"=> 24),

                array("fonctionnalite"=>"renouvellement", "id"=> 20),
                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5),
                array("fonctionnalite"=>"renouvellement", "id"=> 20),
              
            ));
            
            if($droitsMenuPrincipal["lister"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $deleteForm = $this->createDeleteForm($renouvellement);     
        
        $achats = array();

        foreach ($renouvellement->getAchats() as $key => $achat) {
        dump($achat->getFacture());
        if(!is_null($achat->getFacture()))
            $achats[] = array(
                'achat' => $achat,
                'total' => $this->get("service.custom")->calculerTotal($achat->getFacture()->getId()),
                'nbrProduits' => $this->get("service.custom")->calculnombreproduit($achat->getId()),
            );
        }      
        
        $resultat = array(
            'id'     => $renouvellement->getId(),
            'numero' => $renouvellement->getNumero(),
            'DateRenouvellement' => $renouvellement->getDateRenouvellement(),
            'achats' => $achats,
            'EtatsRenouvellements' => $renouvellement->getEtatsRenouvellements()
    
        );
        
        
        return $this->render('renouvellement/show.html.twig', array(         
            'renouvellement' => $resultat,
            'delete_form' => $deleteForm->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Displays a form to edit an existing renouvellement entity.
     *
     * @Route("/{id}/edit", name="renouvellement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Renouvellement $renouvellement)
    {
        $deleteForm = $this->createDeleteForm($renouvellement);
        $editForm = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\RenouvellementType', $renouvellement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('renouvellement_edit', array('id' => $renouvellement->getId()));
        }

        return $this->render('renouvellement/edit.html.twig', array(
            'renouvellement' => $renouvellement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a renouvellement entity.
     *
     * @Route("/{id}", name="renouvellement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Renouvellement $renouvellement)
    {
        $form = $this->createDeleteForm($renouvellement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($renouvellement);
            $em->flush();
        }

        return $this->redirectToRoute('renouvellement_index');
    }

    /**
     * Creates a form to delete a renouvellement entity.
     *
     * @param Renouvellement $renouvellement The renouvellement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Renouvellement $renouvellement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('renouvellement_delete', array('id' => $renouvellement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
