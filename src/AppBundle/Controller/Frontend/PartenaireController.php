<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class PartenaireController
 * @Route("/partenaire")
 */
class PartenaireController extends Controller
{
    /**
     * @Route("/", name="frontend_partenaire_liste")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $partenaires = $em->getRepository('AppBundle:Partenaire')->findBy(['statut'=>1]);
        return $this->render("frontend/partenaires.html.twig",[
            'partenaires' => $partenaires
        ]);
    }
}
