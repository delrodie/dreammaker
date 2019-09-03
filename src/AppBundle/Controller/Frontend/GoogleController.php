<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class GoogleController
 * @Route("google")
 */
class GoogleController extends Controller
{
    /**
     * @Route("/search", name="google_search")
     */
    public function indexAction()
    {
        return $this->render('frontend/google_search.html.twig',[
            'current_menu' => 'accueil'
        ]);
    }
}
