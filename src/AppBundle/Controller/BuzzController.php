<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Buzz;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Buzz controller.
 *
 * @Route("backend/buzz")
 */
class BuzzController extends Controller
{
    /**
     * Lists all buzz entities.
     *
     * @Route("/", name="backend_buzz_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $buzzs = $em->getRepository('AppBundle:Buzz')->findAll();

        return $this->render('buzz/index.html.twig', array(
            'buzzs' => $buzzs,
        ));
    }

    /**
     * Creates a new buzz entity.
     *
     * @Route("/new", name="backend_buzz_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $buzz = new Buzz();
        $form = $this->createForm('AppBundle\Form\BuzzType', $buzz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume(strip_tags($buzz->getContenu()), 300, '...', true);
            $buzz->setResume($resume);
            $em->persist($buzz);
            $em->flush();

            return $this->redirectToRoute('backend_buzz_show', array('slug' => $buzz->getSlug()));
        }

        return $this->render('buzz/new.html.twig', array(
            'buzz' => $buzz,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a buzz entity.
     *
     * @Route("/{slug}", name="backend_buzz_show")
     * @Method("GET")
     */
    public function showAction(Buzz $buzz)
    {
        $deleteForm = $this->createDeleteForm($buzz);

        return $this->render('buzz/show.html.twig', array(
            'buzz' => $buzz,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing buzz entity.
     *
     * @Route("/{slug}/edit", name="backend_buzz_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Buzz $buzz, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($buzz);
        $editForm = $this->createForm('AppBundle\Form\BuzzType', $buzz);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume(strip_tags($buzz->getContenu()), 300, '...', true);
            $buzz->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_buzz_edit', array('slug' => $buzz->getSlug()));
        }

        return $this->render('buzz/edit.html.twig', array(
            'buzz' => $buzz,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a buzz entity.
     *
     * @Route("/{id}", name="backend_buzz_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Buzz $buzz)
    {
        $form = $this->createDeleteForm($buzz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($buzz);
            $em->flush();
        }

        return $this->redirectToRoute('backend_buzz_index');
    }

    /**
     * Creates a form to delete a buzz entity.
     *
     * @param Buzz $buzz The buzz entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Buzz $buzz)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_buzz_delete', array('id' => $buzz->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
