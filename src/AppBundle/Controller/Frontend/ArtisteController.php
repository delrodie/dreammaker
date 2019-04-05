<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Album;
use AppBundle\Entity\Artiste;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class ArtisteController
 * @Route("notre-label")
 */
class ArtisteController extends Controller
{
    /**
     * Liste des artistes
     * @Route("/", name="frontend_label_index")
     */
    public function indexAcion()
    {
        $em = $this->getDoctrine()->getManager();
        $artistes = $em->getRepository('AppBundle:Artiste')->findBy(['statut'=>1], ['flag'=>'DESC']);

        return $this->render('frontend/artistes.html.twig',[
            'artistes' => $artistes,
            'current_menu' => 'label',
        ]);
    }

    /**
     * @param Artiste $artiste
     * @Route("/{slug}", name="frontend_label_artiste")
     * @Method("GET")
     */
    public function showAction(Artiste $artiste)
    {
        $em = $this->getDoctrine()->getManager();
        $albums = $em->getRepository('AppBundle:Album')->findBy(['artiste'=>$artiste->getId(), 'statut'=>1], ['id'=>'DESC']);
        return $this->render('frontend/artiste_show.html.twig',[
            'artiste' => $artiste,
            'albums' => $albums,
            'current_menu' => 'label'
        ]);
    }

    /**
     * @Route("/album/{slug}", name="frontend_label_album")
     * @Method("GET")
     */
    public function albumAction(Album $album)
    {
        return $this->render('frontend/artiste_album.html.twig',[
            'album' => $album,
            'current_menu' => 'label'
        ]);
    }
}
