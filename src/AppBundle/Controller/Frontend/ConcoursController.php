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
        return $this->render("frontend/concours_show.html.html.twig",[
            'concour' => $concours,
            'current_menu' => 'actualite'
        ]);
    }
}