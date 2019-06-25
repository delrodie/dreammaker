<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Concours;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ConcoursController
 * @Route("/concours")
 */
class ConcoursController extends Controller
{
    /**
     * Liste des concours
     * @Route("/", name="frontend_concours_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $concour = $em->getRepository("AppBundle:Concours")->findOneBy(['statut'=>1], ['id'=>'DESC']);
        return;
    }

    /**
     * @Route("/{slug}", name="frontend_concours_show")
     * @Method("GET")
     */
    public function showAction(Concours $concours)
    {
        return $this->render("frontend/concours_show.html.twig",[
            'concour' => $concours,
            'current_menu' => 'event'
        ]);
    }

    /**
     * @Route("/{concours}/reglement", name="frontend_concours_reglement")
     * @Method("GET")
     */
    public function reglementAction($concours)
    {
        $em = $this->getDoctrine()->getManager();
        $concours = $em->getRepository("AppBundle:Concours")->findOneBy(['slug'=>$concours]);
        $reglement = $em->getRepository("AppBundle:Reglement")->findOneBy(['concours'=>$concours]);
        return $this->render("frontend/reglement_show.html.twig",[
            'reglement' => $reglement,
            'current_menu' => 'event'
        ]);
    }

    /**
     * @Route("/item/{reglement}", name="frontend_reglement_item")
     * @Method("GET")
     */
    public function itemAction($reglement)
    {
        $em = $this->getDoctrine()->getManager();
        $reglement = $em->getRepository("AppBundle:Reglement")->findOneBy(['id'=>$reglement]);
        $items = $em->getRepository("AppBundle:Item")->findBy(['reglement'=>$reglement]);
        return $this->render("frontend/item.html.twig",[
            'items' => $items
        ]);
    }
}