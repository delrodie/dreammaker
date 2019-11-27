<?php


namespace AppBundle\Controller\Frontend;


use AppBundle\Entity\Buzz;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class BuzzController
 * @Route("/buzz")
 */
class BuzzController extends Controller
{
    /**
     * @Route("/", name="frontend_buzz_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $buzzs = $em->getRepository("AppBundle:Buzz")->findBy(['statut'=>1],['id'=>'DESC']);

        return $this->render("frontend/buzzs.html.twig",[
            'buzzs' => $buzzs,
            'current_menu' => 'buzz'
        ]);
    }

    /**
     * @Route("/{slug}", name="frontend_buzz_show")
     * @Method("GET")
     */
    public function showAction(Buzz $buzz)
    {
        return $this->render("frontend/buzz_show.html.html.twig",[
            'buzz' => $buzz,
            'current_menu' => 'buzz'
        ]);
    }
}
