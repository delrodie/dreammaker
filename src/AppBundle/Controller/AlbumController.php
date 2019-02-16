<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Album;
use AppBundle\Utils\Label;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Album controller.
 *
 * @Route("backend/album")
 */
class AlbumController extends Controller
{
    /**
     * Lists all album entities.
     *
     * @Route("/", name="backend_album_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $albums = $em->getRepository('AppBundle:Album')->findAll();

        return $this->render('album/index.html.twig', array(
            'albums' => $albums,
        ));
    }

    /**
     * Creates a new album entity.
     *
     * @Route("/new", name="backend_album_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Label $label)
    {
        $album = new Album();
        $form = $this->createForm('AppBundle\Form\AlbumType', $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($album);
            $em->flush();

            $maj_artiste = $label->increaseAlbum($album->getArtiste()->getId());
            if ($maj_artiste){
                return $this->redirectToRoute('backend_album_show', array('slug' => $album->getSlug()));
            }else{
                return $this->redirectToRoute('backend_album_delete', ['id'=> $album->getId()]);
            }


        }

        return $this->render('album/new.html.twig', array(
            'album' => $album,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a album entity.
     *
     * @Route("/{slug}", name="backend_album_show")
     * @Method("GET")
     */
    public function showAction(Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);

        $em = $this->getDoctrine()->getManager();
        $chansons = $em->getRepository('AppBundle:Chanson')->findBy(['album'=>$album->getId()]);

        return $this->render('album/show.html.twig', array(
            'album' => $album,
            'chansons' => $chansons,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing album entity.
     *
     * @Route("/{slug}/edit", name="backend_album_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Album $album)
    {
        $deleteForm = $this->createDeleteForm($album);
        $editForm = $this->createForm('AppBundle\Form\AlbumType', $album);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_album_show', array('slug' => $album->getSlug()));
        }

        return $this->render('album/edit.html.twig', array(
            'album' => $album,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a album entity.
     *
     * @Route("/{id}", name="backend_album_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Album $album, Label $label)
    {
        $form = $this->createDeleteForm($album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $artiste = $album->getArtiste()->getId();
            $em->remove($album);
            $em->flush();

            $label->decreaseAlbum($artiste);
        }

        return $this->redirectToRoute('backend_album_index');
    }

    /**
     * Creates a form to delete a album entity.
     *
     * @param Album $album The album entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Album $album)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_album_delete', array('id' => $album->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
