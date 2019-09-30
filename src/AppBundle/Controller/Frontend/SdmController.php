<?php


namespace AppBundle\Controller\Frontend;


use AppBundle\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class SdmController
 * @Route("/sdm2019")
 */
class SdmController extends Controller
{
    /**
     * @Route("/", name="sdm_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $candidats = $em->getRepository("AppBundle:Candidat")->findAll();

        return $this->render('frontend/sdm_list.html.twig',[
            'candidats' => $candidats
        ]);
    }

    /**
     * @Route("/{slug}", name="sdm_show")
     * @Method("GET")
     */
    public function showAction(Candidat $candidat)
    {
        $em = $this->getDoctrine()->getManager();
        $candidats = $em->getRepository("AppBundle:Candidat")->findAutresCandidats($candidat->getId());
        return $this->render("frontend/sdm_show.html.twig",[
            'candidat' => $candidat,
            'candidats' => $candidats,
        ]);
    }
}
