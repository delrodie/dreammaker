<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Chanson;
use AppBundle\Utils\Label;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Chanson controller.
 *
 * @Route("backend/chanson")
 */
class ChansonController extends Controller
{
    /**
     * Lists all chanson entities.
     *
     * @Route("/", name="backend_chanson_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $chansons = $em->getRepository('AppBundle:Chanson')->findAll();

        return $this->render('chanson/index.html.twig', array(
            'chansons' => $chansons,
        ));
    }

    /**
     * Creates a new chanson entity.
     *
     * @Route("/new/{album}", name="backend_chanson_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $album, Label $label)
    {
        $chanson = new Chanson();
        $form = $this->createForm('AppBundle\Form\ChansonType', $chanson, ['album'=>$album]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($chanson);
            $em->flush();

            $maj_album= $label->increasePiste($album);

            if ($maj_album){
                return $this->redirectToRoute('backend_chanson_new', array('album' => $album));
            }else{
                return $this->redirectToRoute('backend_album_delete',['id'=>$chanson->getId()]);
            }


        }

        $em = $this->getDoctrine()->getManager();

        $chansons = $em->getRepository('AppBundle:Chanson')->findBy(['album'=>$album]);
        $albums = $em->getRepository('AppBundle:Album')->findOneBy(['id'=>$album]);

        return $this->render('chanson/new.html.twig', array(
            'chanson' => $chanson,
            'chansons' => $chansons,
            'album' => $albums,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a chanson entity.
     *
     * @Route("/{id}", name="backend_chanson_show")
     * @Method("GET")
     */
    public function showAction(Chanson $chanson)
    {
        $deleteForm = $this->createDeleteForm($chanson);

        return $this->render('chanson/show.html.twig', array(
            'chanson' => $chanson,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing chanson entity.
     *
     * @Route("/{slug}/edit", name="backend_chanson_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Chanson $chanson)
    {
        $deleteForm = $this->createDeleteForm($chanson);
        $editForm = $this->createForm('AppBundle\Form\ChansonType', $chanson, ['album'=>$chanson->getAlbum()->getId()]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_chanson_new', array('album' => $chanson->getAlbum()->getId()));
        }
        $em = $this->getDoctrine()->getManager();
        $album = $em->getRepository('AppBundle:Album')->findOneBy(['id'=>$chanson->getAlbum()->getId()]);
        $chansons = $em->getRepository('AppBundle:Chanson')->findBy(['album'=>$chanson->getAlbum()->getId()]);

        return $this->render('chanson/edit.html.twig', array(
            'chansons' => $chansons,
            'chanson' => $chanson,
            'album' => $album,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a chanson entity.
     *
     * @Route("/{id}", name="backend_chanson_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Chanson $chanson, Label $label)
    {
        $form = $this->createDeleteForm($chanson);
        $form->handleRequest($request);
        $album = $chanson->getAlbum()->getId();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($chanson);
            $em->flush();

            $label->decreasePiste($album);
        }

        return $this->redirectToRoute('backend_chanson_new', ['album'=>$album]);
    }

    /**
     * Creates a form to delete a chanson entity.
     *
     * @param Chanson $chanson The chanson entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Chanson $chanson)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_chanson_delete', array('id' => $chanson->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
