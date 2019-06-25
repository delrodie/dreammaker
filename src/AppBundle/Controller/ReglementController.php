<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reglement;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Reglement controller.
 *
 * @Route("backend/reglement")
 */
class ReglementController extends Controller
{
    /**
     * Lists all reglement entities.
     *
     * @Route("/", name="backend_reglement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reglements = $em->getRepository('AppBundle:Reglement')->findAll();

        return $this->render('reglement/index.html.twig', array(
            'reglements' => $reglements,
        ));
    }

    /**
     * Creates a new reglement entity.
     *
     * @Route("/new", name="backend_reglement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $reglement = new Reglement();
        $form = $this->createForm('AppBundle\Form\ReglementType', $reglement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume(strip_tags($reglement->getContenu()), 300, '...', true);
            $reglement->setResume($resume);
            $em->persist($reglement);
            $em->flush();

            return $this->redirectToRoute('backend_reglement_show', array('slug' => $reglement->getSlug()));
        }

        return $this->render('reglement/new.html.twig', array(
            'reglement' => $reglement,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reglement entity.
     *
     * @Route("/{slug}", name="backend_reglement_show")
     * @Method("GET")
     */
    public function showAction(Reglement $reglement)
    {
        $deleteForm = $this->createDeleteForm($reglement);

        return $this->render('reglement/show.html.twig', array(
            'reglement' => $reglement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reglement entity.
     *
     * @Route("/{slug}/edit", name="backend_reglement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reglement $reglement, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($reglement);
        $editForm = $this->createForm('AppBundle\Form\ReglementType', $reglement);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume(strip_tags($reglement->getContenu()), 300, '...', true);
            $reglement->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_reglement_show', array('slug' => $reglement->getSlug()));
        }

        return $this->render('reglement/edit.html.twig', array(
            'reglement' => $reglement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reglement entity.
     *
     * @Route("/{id}", name="backend_reglement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reglement $reglement)
    {
        $form = $this->createDeleteForm($reglement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reglement);
            $em->flush();
        }

        return $this->redirectToRoute('backend_reglement_index');
    }

    /**
     * Creates a form to delete a reglement entity.
     *
     * @param Reglement $reglement The reglement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reglement $reglement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_reglement_delete', array('id' => $reglement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
