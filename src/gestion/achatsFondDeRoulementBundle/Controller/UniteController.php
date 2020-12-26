<?php

namespace gestion\achatsFondDeRoulementBundle\Controller;

use gestion\achatsFondDeRoulementBundle\Entity\Unite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use gestion\achatsFondDeRoulementBundle\Entity\Uniterattache;

/**
 * Unite controller.
 *
 * @Route("unite")
 */
class UniteController extends Controller
{
    /**
     * Lists all unite entities.
     *
     * @Route("/", name="unite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $unites = $em->getRepository('gestionachatsFondDeRoulementBundle:Unite')->findAll();

        return $this->render('unite/index.html.twig', array(
            'unites' => $unites,
        ));
    }

    /**
     * Creates a new unite entity.
     *
     * @Route("/new", name="unite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();    
        $uniterataches = new Uniterattache();
        $uniterataches->setLibelle(null);
        $unite = new Unite();
        $unite->getUniterataches()->add($uniterataches);
        $form = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\UniteType', $unite);
        $form->handleRequest($request);       

        if ($form->isSubmitted() && $form->isValid()) {

             foreach ($unite->getUniterataches() as $ligne) {
                $ligne->setUnitee($unite);
            }

            
          
            $em->persist($unite);
            $em->flush();

            return $this->redirectToRoute('unite_show', array('id' => $unite->getId()));
        }

        return $this->render('unite/new.html.twig', array(
            'unite' => $unite,
            'form' => $form->createView(),
            
        ));
    }

    /**
     * Finds and displays a unite entity.
     *
     * @Route("/{id}", name="unite_show")
     * @Method("GET")
     */
    public function showAction(Unite $unite)
    {
        $deleteForm = $this->createDeleteForm($unite);

        return $this->render('unite/show.html.twig', array(
            'unite' => $unite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing unite entity.
     *
     * @Route("/{id}/edit", name="unite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Unite $unite)
    {
        $deleteForm = $this->createDeleteForm($unite);
        $editForm = $this->createForm('gestion\achatsFondDeRoulementBundle\Form\UniteType', $unite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('unite_edit', array('id' => $unite->getId()));
        }

        return $this->render('unite/edit.html.twig', array(
            'unite' => $unite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a unite entity.
     *
     * @Route("/{id}", name="unite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Unite $unite)
    {
        $form = $this->createDeleteForm($unite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($unite);
            $em->flush();
        }

        return $this->redirectToRoute('unite_index');
    }

    /**
     * Creates a form to delete a unite entity.
     *
     * @param Unite $unite The unite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Unite $unite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('unite_delete', array('id' => $unite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
