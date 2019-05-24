<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Event;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class EventController
 * @Route("/events")
 */
class EventController extends Controller
{
    /**
     * @Route("/", name="frontend_event_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('AppBundle:Event')->findAll();

        return $this->render("frontend/events.html.twig",[
            'events' => $events,
            'current_menu' => 'event'
        ]);
    }

    /**
     * @Route("/{slug}", name="frontend_event_show")
     * @Method("GET")
     */
    public function showAction(Event $event)
    {
        return $this->render("frontend/event_show.html.twig",[
            'event' => $event,
            'current_menu' => 'event'
        ]);
    }


}