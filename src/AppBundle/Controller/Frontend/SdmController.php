<?php


namespace AppBundle\Controller\Frontend;


use AppBundle\Entity\Candidat;
use AppBundle\Utils\GestionVote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

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
        $session = new Session();
        if (!$session->get('vote')){
            $vote = true;
        }else{
            $vote = false;
        }
        $em = $this->getDoctrine()->getManager();
        $candidats = $em->getRepository("AppBundle:Candidat")->findList();

        return $this->render('frontend/sdm_list.html.twig',[
            'candidats' => $candidats,
            'vote' => $vote,
        ]);
    }

    /**
     * @Route("/{slug}", name="sdm_show")
     * @Method("GET")
     */
    public function showAction(Candidat $candidat)
    {
        $session = new Session();
        if (!$session->get('vote')){
            $vote = true;
        }else{
            $vote = false;
        }
        $em = $this->getDoctrine()->getManager();
        $candidats = $em->getRepository("AppBundle:Candidat")->findAutresCandidats($candidat->getId());
        return $this->render("frontend/sdm_show.html.twig",[
            'candidat' => $candidat,
            'candidats' => $candidats,
            'vote' => $vote,
        ]);
    }

    /**
     * @Route("/vote/{slug}", name="sdm_vote")
     * @Method("GET")
     */
    public function voteAction(Candidat $candidat, GestionVote $gestionVote)
    {
        $session = new Session();

        // S'il n'y a pas de session alors ajout de vote au candidat concerné et creation de session
        if (!$session->get('vote')){
            $gestionVote->vote($candidat->getSlug(),1);
            $session->set('vote', $candidat->getSlug());

        }

        return $this->redirectToRoute("sdm_show",['slug'=>$candidat->getSlug()]);

    }
}
