<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Actualite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class ActualiteController
 * @Route("actualites")
 */
class ActualiteController extends Controller
{
    /**
     * @Route("/", name="frontend_actualite_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $actualites = $em->getRepository('AppBundle:Actualite')->findList(1);

        return $this->render("frontend/actualites.html.twig",[
            'actualites' => $actualites,
            'current_menu' => "actualite"
        ]);
    }

    /**
     * @param Actualite $actualite
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/{slug}", name="frontend_actualite_show")
     * @Method("GET")
     */
    public function showAcion(Actualite $actualite)
    {
        return $this->render('frontend/actualite_show.html.html.twig',[
            'actualite' => $actualite,
            'current_menu' => 'actualite'
        ]);
    }
}
