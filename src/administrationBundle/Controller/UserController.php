<?php

namespace administrationBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use administrationBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Controller\RegistrationController as BaseController;

/**
 * User controller.
 *
 * @Route("user")
 */
class UserController extends BaseController
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 1),
                array("fonctionnalite"=>"lister", "id"=> 4),

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
        
        $users = $em->getRepository('administrationBundle:User')->findAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Finds and displays a profil entity.
     *
     * @Route("/{id}", name="user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $loggedUser = $this->getUser();
        if (!is_object($loggedUser) || !$loggedUser instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($loggedUser->getProfil()->getId(),array(
                array("fonctionnalite"=>"modifier", "id"=> 2),
                array("fonctionnalite"=>"lister", "id"=> 4),
                array("fonctionnalite"=>"activer", "id"=> 3),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5)
            ));

            if($droitsMenuPrincipal["lister"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Finds and displays a profil entity.
     *
     * @Route("/profil/{id}", name="profil_show")
     * @Method("GET")
     */
    public function profilShowAction(User $user)
    {
        $loggedUser = $this->getUser();
        if (!is_object($loggedUser) || !$loggedUser instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($loggedUser->getProfil()->getId(),array(
                array("fonctionnalite"=>"modifier", "id"=> 2),
                array("fonctionnalite"=>"lister", "id"=> 4),
                array("fonctionnalite"=>"activer", "id"=> 3),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5)
            ));

            if($droitsMenuPrincipal["lister"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Finds and displays a profil entity.
     *
     * @Route("/update/{id}", name="user_update")
     * @Method({"GET", "POST"})
     */
    public function updateAction(Request $request, User $user){

        $loggedUser = $this->getUser();
        if (!is_object($loggedUser) || !$loggedUser instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($loggedUser->getProfil()->getId(),array(
                array("fonctionnalite"=>"editer", "id"=> 2),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5)
            ));

            if($droitsMenuPrincipal["editer"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $em = $this->get('fos_user.user_manager');
        $form = $this->createForm('administrationBundle\Form\RegistrationType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->updateUser($user, false);
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Vos modifications ont ete enregistrees.");
            return $this->redirect($this->generateUrl('user_index'));
        }
        $this->get('session')->getFlashBag()->add('error', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render('user/edit.html.twig', array(
            'user' => $user, 
            'edit_form' => $form->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Finds and displays a profil entity.
     *
     * @Route("/profilUpdate/{id}", name="profil_edit")
     * @Method({"GET", "POST"})
     */
    public function profilUpdateAction(Request $request, User $user){

        $loggedUser = $this->getUser();
        if (!is_object($loggedUser) || !$loggedUser instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($loggedUser->getProfil()->getId(),array(
                array("fonctionnalite"=>"editer", "id"=> 2),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5)
            ));

            if($droitsMenuPrincipal["editer"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $em = $this->get('fos_user.user_manager');
        $form = $this->createForm('administrationBundle\Form\RegistrationType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->updateUser($user, false);
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Vos modifications ont ete enregistrees.");
            return $this->redirect($this->generateUrl('user_index'));
        }
        $this->get('session')->getFlashBag()->add('error', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render('user/edit.html.twig', array(
            'user' => $user, 
            'edit_form' => $form->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }

    /**
     * Finds and displays a profil entity.
     *
     * @Route("/updatePassword/{id}", name="user_update_password")
     * @Method({"GET", "POST"})
     */
    public function updatePasswordAction(Request $request, User $user){
        $em = $this->get('fos_user.user_manager');
        $form = $this->createForm('administrationBundle\Form\RegistrationType', $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->updateUser($user, false);
            $this->getDoctrine()->getManager()->flush();
            $this->get('session')->getFlashBag()->add('success', "Vos modifications ont ete enregistrees.");
            return $this->redirect($this->generateUrl('user_show', array('id' => $user->getId())));
        }
        $this->get('session')->getFlashBag()->add('error', "Il y a des erreurs dans le formulaire soumis !");

        return $this->render('user/edit_password.html.twig', array('user' => $user, 'edit_form' => $form->createView()));
    }

    /**
     * Finds and displays a profil entity.
     *
     * @Route("/activate/{id}", name="user_activate")
     * @Method({"GET", "POST"})
     */
    public function activeAction($id)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"activer", "id"=> 3),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5)
            ));

            if($droitsMenuPrincipal["editer"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('administrationBundle:User')->find($id);
        if($user->isEnabled()==true){
            $user->setEnabled(false);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "Vos modifications ont ete enregistrees vos compte est desactive.");
        }else{
            $user->setEnabled(true);
            $em->flush();
            $this->get('session')->getFlashBag()->add('info', "Vos modifications ont ete enregistrees  vos compte est active.");
        }
        return $this->redirect($this->generateUrl('user_show', array(
            'id' => $user->getId(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        )));

    }

    public function registerAction(Request $request)
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }else{
            $droitsMenuPrincipal = $this->get("admin.access")->checkMainMenuAccess($user->getProfil()->getId(),array(
                array("fonctionnalite"=>"ajouter", "id"=> 1),

                array("fonctionnalite"=>"demande", "id"=> 9),
                array("fonctionnalite"=>"achat", "id"=> 13),
                array("fonctionnalite"=>"utilisateur", "id"=> 4),
                array("fonctionnalite"=>"profil", "id"=> 5)
            ));

            if($droitsMenuPrincipal["editer"]=="0"){
                return $this->redirect($this->generateUrl('fos_user_security_login'));    
            }
        }

        /** @var $formFactory FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');

        $user = $userManager->createUser();
        $user->setEnabled(true);

        $event = new GetResponseUserEvent($user, $request);
        $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

        if (null !== $event->getResponse()) {
            return $event->getResponse();
        }

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $userManager->updateUser($user);

                /*****************************************************
                 * Add new functionality (e.g. log the registration) *
                 *****************************************************/
                $this->container->get('logger')->info(
                    sprintf("New user registration: %s", $user)
                );

                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));

                return $response;
            }

            $event = new FormEvent($form, $request);
            $dispatcher->dispatch(FOSUserEvents::REGISTRATION_FAILURE, $event);

            if (null !== $response = $event->getResponse()) {
                return $response;
            }
        }

        return $this->render('@FOSUser/Registration/register.html.twig', array(
            'form' => $form->createView(),
            'droitsMenuPrincipal' => $droitsMenuPrincipal
        ));
    }
    
}
