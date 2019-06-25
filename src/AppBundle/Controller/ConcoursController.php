<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Concours;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Concour controller.
 *
 * @Route("backend/concours")
 */
class ConcoursController extends Controller
{
    /**
     * Lists all concour entities.
     *
     * @Route("/", name="backend_concours_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $concours = $em->getRepository('AppBundle:Concours')->findAll();

        return $this->render('concours/index.html.twig', array(
            'concours' => $concours,
        ));
    }

    /**
     * Creates a new concour entity.
     *
     * @Route("/new", name="backend_concours_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $concour = new Concours();
        $form = $this->createForm('AppBundle\Form\ConcoursType', $concour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume(strip_tags($concour->getContenu()), 300, '...', true);
            $concour->setResume($resume);
            $em->persist($concour);
            $em->flush();

            return $this->redirectToRoute('backend_concours_show', array('slug' => $concour->getSlug()));
        }

        return $this->render('concours/new.html.twig', array(
            'concour' => $concour,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a concour entity.
     *
     * @Route("/{slug}", name="backend_concours_show")
     * @Method("GET")
     */
    public function showAction(Concours $concour)
    {
        $deleteForm = $this->createDeleteForm($concour);

        return $this->render('concours/show.html.twig', array(
            'concour' => $concour,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing concour entity.
     *
     * @Route("/{slug}/edit", name="backend_concours_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Concours $concour, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($concour);
        $editForm = $this->createForm('AppBundle\Form\ConcoursType', $concour);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume(strip_tags($concour->getContenu()), 300, '...', true);
            $concour->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_concours_show', array('slug' => $concour->getSlug()));
        }

        return $this->render('concours/edit.html.twig', array(
            'concour' => $concour,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a concour entity.
     *
     * @Route("/{id}", name="backend_concours_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Concours $concour)
    {
        $form = $this->createDeleteForm($concour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($concour);
            $em->flush();
        }

        return $this->redirectToRoute('backend_concours_index');
    }

    /**
     * Creates a form to delete a concour entity.
     *
     * @param Concours $concour The concour entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Concours $concour)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_concours_delete', array('id' => $concour->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
