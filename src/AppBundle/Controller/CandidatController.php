<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Candidat;
use AppBundle\Utils\GestionVote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Candidat controller.
 *
 * @Route("backend/candidat")
 */
class CandidatController extends Controller
{
    /**
     * Lists all candidat entities.
     *
     * @Route("/", name="backend_candidat_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $candidats = $em->getRepository('AppBundle:Candidat')->findAll();

        return $this->render('candidat/index.html.twig', array(
            'candidats' => $candidats,
        ));
    }

    /**
     * Creates a new candidat entity.
     *
     * @Route("/new", name="backend_candidat_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $candidat = new Candidat();
        $form = $this->createForm('AppBundle\Form\CandidatType', $candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidat);
            $em->flush();

            return $this->redirectToRoute('backend_candidat_show', array('slug' => $candidat->getSlug()));
        }

        return $this->render('candidat/new.html.twig', array(
            'candidat' => $candidat,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a candidat entity.
     *
     * @Route("/{slug}", name="backend_candidat_show")
     * @Method("GET")
     */
    public function showAction(Candidat $candidat)
    {
        $deleteForm = $this->createDeleteForm($candidat);

        return $this->render('candidat/show.html.twig', array(
            'candidat' => $candidat,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing candidat entity.
     *
     * @Route("/{slug}/edit", name="backend_candidat_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Candidat $candidat, GestionVote $gestionVote)
    {
        $deleteForm = $this->createDeleteForm($candidat);
        $editForm = $this->createForm('AppBundle\Form\CandidatType', $candidat);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $pointFbk = $candidat->getPointFacebook();
            $pointSMS = $candidat->getPointUreport();
            $gestionVote->vote($candidat->getSlug(),0,$pointFbk,$pointSMS);
            //$this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('backend_candidat_show', array('slug' => $candidat->getSlug()));
        }

        return $this->render('candidat/edit.html.twig', array(
            'candidat' => $candidat,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a candidat entity.
     *
     * @Route("/{id}", name="backend_candidat_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Candidat $candidat)
    {
        $form = $this->createDeleteForm($candidat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($candidat);
            $em->flush();
        }

        return $this->redirectToRoute('backend_candidat_index');
    }

    /**
     * Creates a form to delete a candidat entity.
     *
     * @param Candidat $candidat The candidat entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Candidat $candidat)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_candidat_delete', array('id' => $candidat->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
