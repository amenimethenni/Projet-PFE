<?php

namespace administrationBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use administrationBundle\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Profil controller.
 *
 * @Route("profil")
 */
class ProfilController extends Controller
{
    /**
     * Lists all profil entities.
     *
     * @Route("/", name="profil_index")
     * @Method("GET")
     */
    public function indexAction()
    {

        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 6),
                array("fonctionnalite"=>"lister", "id"=> 5),
                array("fonctionnalite"=>"modifier", "id"=> 7),
                array("fonctionnalite"=>"supprimer", "id"=> 8),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5)
            ));
            
            if($droitsMenuPrincipal["lister"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('administrationBundle:Profil')->findAll();
        $profilsList = array();
        foreach ($profils as $key => $profil) {
            array_push($profilsList, array(
                'profil' => $profil,
                'nbrUsers' => count($em->getRepository('administrationBundle:User')->findBy(array('profil' => $profil)))
            ));
        }

        $droits = array();
        $modules = $em->getRepository('administrationBundle:Module')->findAll();
        foreach ($modules as $key => $module) {
            $fonctionnalites = $em->getRepository('administrationBundle:Fonctionnalite')->findBy(array('module'=>$module));
            array_push($droits, array(
                'module' => $module,
                'fonctionnalites' => $fonctionnalites
            ));
        }

        return $this->render('profil/index.html.twig', array(
            'profils' => $profilsList,
            'droits'  => $droits,
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Get product datas.
     *
     * @Route("/profilHasFonctionnalite", name="ajax_profil_has__fonctionnalites")
     * @Method("POST")
     */
    public function ajaxProfilHasFonctionnaliteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $droits = array();
        $modules = $em->getRepository('administrationBundle:Module')->findAll();
        foreach ($modules as $key => $module) {
            $fonctionnalites = $em->getRepository('administrationBundle:Fonctionnalite')->findBy(array('module'=>$module));
            $profil = $em->getRepository('administrationBundle:Profil')->find($request->request->get('id'));
            $droit = array();
            foreach ($fonctionnalites as $key2 => $fonctionnalite) {

                array_push($droit, array(
                    'functionnalite' => $fonctionnalite->getID(),
                    'droit' => count($em->getRepository('administrationBundle:Profil')
                                  ->findFonctionnaliesByProfil($profil->getId(),$fonctionnalite->getId()))
                ));  
            }
            array_push($droits, array(
                'module' => $module,
                'droits' => $droit
            ));
        }
        
        return new Response(json_encode($droits)); 
    }

    /**
     * Get product datas.
     *
     * @Route("/profilGrantFonctionnalite", name="ajax_grant_fonctionnalite")
     * @Method("POST")
     */
    public function profilGrantFonctionnaliteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository('administrationBundle:Profil')->find($request->request->get('profil_id'));
        $fonctionnalite = $em->getRepository('administrationBundle:Fonctionnalite')->find($request->request->get('fonctionnalite_id'));
        
        $profil->getFonctionnalites()->add($fonctionnalite);
        $em->persist($profil);
        $em->flush();

        return new Response('ok'); 
    }

    /**
     * Get product datas.
     *
     * @Route("/profilGrantModule", name="ajax_grant_module")
     * @Method("POST")
     */
    public function profilGrantModuleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository('administrationBundle:Profil')->find($request->request->get('profil_id'));

        //  effacer les fonctionnalités déjà attribuées
        foreach ($profil->getFonctionnalites() as $key => $fonctionnalite) {
            $profil->getFonctionnalites()->removeElement($fonctionnalite);
        }

        //  affecter toutes les fonctionnalites du module choisit
        $fonctionnalites = $em->getRepository('administrationBundle:Fonctionnalite')->findBy(array('module'=>$request->request->get('profil_id')));
        foreach ($Fonctionnalites as $key => $fonctionnalite) {
            $profil->getFonctionnalites()->add($fonctionnalite);
        }        
        
        $em->persist($profil);
        $em->flush();

        return new Response('ok'); 
    }

    /**
     * Get product datas.
     *
     * @Route("/ajaxDeleteProfil", name="ajaxDeleteProfil")
     * @Method("POST")
     */
    public function ajaxDeleteProfilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository('administrationBundle:Profil')->find($request->request->get('profil_id'));
        $em->remove($profil);
        $em->flush();

        return new Response('ok'); 
    }

    /**
     * Get product datas.
     *
     * @Route("/ajaxAddProfil", name="ajaxAddProfil")
     * @Method("POST")
     */
    public function ajaxAddProfilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profil = new Profil();
        $profil->setLibelle($request->request->get('libelle'));
        $em->persist($profil);
        $em->flush();

        return new Response($profil->getId()); 
    }

    /**
     * Get product datas.
     *
     * @Route("/profilRetreiveModule", name="ajax_retreive_module")
     * @Method("POST")
     */
    public function profilRetreiveModuleAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository('administrationBundle:Profil')->find($request->request->get('profil_id'));

        //  effacer les fonctionnalités déjà attribuées
        foreach ($profil->getFonctionnalites() as $key => $fonctionnalite) {
            $profil->getFonctionnalites()->removeElement($fonctionnalite);
        }   
        
        $em->persist($profil);
        $em->flush();

        return new Response('ok'); 
    }

    /**
     * Get product datas.
     *
     * @Route("/ajaxUserHasProfil", name="ajaxUserHasProfil")
     * @Method("POST")
     */
    public function ajaxUserHasProfilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('administrationBundle:User')->findBy(array('profil'=>$request->request->get('profil_id')));
        return new Response(count($users)); 
    }

    /**
     * Get product datas.
     *
     * @Route("/profilRetreiveFonctionnalite", name="ajax_retreive_fonctionnalite")
     * @Method("POST")
     */
    public function profilRetreiveFonctionnaliteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository('administrationBundle:Profil')->find($request->request->get('profil_id'));
        $fonctionnalite = $em->getRepository('administrationBundle:Fonctionnalite')->find($request->request->get('fonctionnalite_id'));
        
        $profil->getFonctionnalites()->removeElement($fonctionnalite);
        $em->persist($profil);
        $em->flush();

        return new Response('ok'); 
    }

    /**
     * Creates a new profil entity.
     *
     * @Route("/new", name="profil_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $profil = new Profil();
        $form = $this->createForm('administrationBundle\Form\ProfilType', $profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($profil);
            $em->flush();

            return $this->redirectToRoute('profil_show', array('id' => $profil->getId()));
        }

        return $this->render('profil/new.html.twig', array(
            'profil' => $profil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a profil entity.
     *
     * @Route("/{id}", name="profil_show")
     * @Method("GET")
     */
    public function showAction(Profil $profil)
    {
        $deleteForm = $this->createDeleteForm($profil);

        return $this->render('profil/show.html.twig', array(
            'profil' => $profil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing profil entity.
     *
     * @Route("/{id}/edit", name="profil_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Profil $profil)
    {
        $deleteForm = $this->createDeleteForm($profil);
        $editForm = $this->createForm('administrationBundle\Form\ProfilType', $profil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil_edit', array('id' => $profil->getId()));
        }

        return $this->render('profil/edit.html.twig', array(
            'profil' => $profil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a profil entity.
     *
     * @Route("/{id}", name="profil_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Profil $profil)
    {
        $form = $this->createDeleteForm($profil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($profil);
            $em->flush();
        }

        return $this->redirectToRoute('profil_index');
    }

    /**
     * Creates a form to delete a profil entity.
     *
     * @param Profil $profil The profil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Profil $profil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profil_delete', array('id' => $profil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


}
