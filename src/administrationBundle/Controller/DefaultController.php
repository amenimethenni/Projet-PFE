<?php

namespace administrationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Facture controller.
 *
 * @Route("admin/user")
 */
class DefaultController extends Controller
{
    
    /**
     * Add new user
     *
     * @Route("/add", name="fos_new_user")
     * @Method({"GET", "POST"})
     */
    public function addAction(request $request) {
       
        $loggedUser = $this->getUser();
        if ($loggedUser instanceof UserInterface) {
            return $this->redirect($this->generateUrl("espace_prive"));
        }
        
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->get('fos_user.registration.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->get('event_dispatcher');
                            
        $formFactory = $this->get('fos_user.registration.form.factory');
        $form = $formFactory->createForm();
        
        $form->handleRequest($request);
        
        $erreurs = array();
        if ($form->isValid()) {
                $user = $userManager->createUser();

                $event = new GetResponseUserEvent($user, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_INITIALIZE, $event);

                $event = new FormEvent($form, $request);
                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);

                $user = $form->getData();
                $user->setEnabled(true);
                
                if(empty($form->get('email')->getData()))
                    $user->setEmail("recrutement@transtu.tn");
                $userManager->updateUser($user);
                if (null === $response = $event->getResponse()) {
                    $url = $this->generateUrl('fos_user_registration_confirmed');
                    $response = new RedirectResponse($url);
                }

                $dispatcher->dispatch(FOSUserEvents::REGISTRATION_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
                
                /*
                 * Rediriger le candidat vers l'espace
                 */
                // $url = $this->generateUrl('imprimer_fiche' , array("id"=>$user->getId()));
                // $response = new RedirectResponse($url);
                // return $response;
                return new Response('ok');
            
        }
        
        return $this->render('recrutementAdministrationBundle:Default:add.html.twig', array(
                    'form' => $form->createView(),
                    'poste' => $poste,
                    'erreurs' => $erreurs,
                    'user' => $loggedUser
        ));
        
    }

}
