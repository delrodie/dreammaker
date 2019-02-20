<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class PresentationController
 * @Route("presentation")
 */
class PresentationController extends Controller
{
    /**
     * @Route("/", name="frontend_presentation_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $presentation = $em->getRepository('AppBundle:Presentation')->findOneBy(['statut'=>1], ['id'=>'DESC']);
        $services = $em->getRepository('AppBundle:Service')->findBy(['statut'=>1]);

        return $this->render("frontend/presentation.html.twig",[
            'presentation' => $presentation,
            'services' => $services,
            'current_menu' => 'presentation'
        ]);
    }
}
