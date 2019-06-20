<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actualites = $em->getRepository('AppBundle:Actualite')->findList(1,4);
        $artistes = $em->getRepository('AppBundle:Artiste')->findArtiste(4);
        $events = $em->getRepository('AppBundle:Event')->findListEvent();
        return $this->render('default/index.html.twig', [
            'current_menu' => 'accueil',
            'actualites' => $actualites,
            'artistes' => $artistes,
            'events' => $events
        ]);
    }

    /**
     * Backoffice: Tableau de bord
     *
     * @Route("/backend", name="backend")
     */
    public function backendAction()
    {
        return $this->render('default/dashboard.html.twig');
    }

    /**
     * @Route("/bock/droit", name="frontend_bloc_droit")
     */
    public function blocAction()
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('AppBundle:Event')->findListEvent(3);
        return $this->render("frontend/bloc_droit.html.html.twig",[
            'events' => $events
        ]);
    }
}
