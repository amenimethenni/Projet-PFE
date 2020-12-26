<?php

namespace gestion\achatsFondDeRoulementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('gestionachatsFondDeRoulementBundle:Default:index.html.twig');
    }

    /**
     * Get product datas.
     *
     * @Route("/productDatas", name="ajax_get_product_datas")
     * @Method("POST")
     */
    public function ajaxGetProductDatasAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('gestionachatsFondDeRoulementBundle:Produit')->find($request->request->get('productId'));
        $response = array(
        	"prix" => $produit->getPrixUnitaire()
        );
        return new Response(json_encode($response)); 
    }

}
