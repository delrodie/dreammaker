<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Item controller.
 *
 * @Route("backend/item")
 */
class ItemController extends Controller
{
    /**
     * Lists all item entities.
     *
     * @Route("/", name="backend_item_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('AppBundle:Item')->findAll();

        return $this->render('item/index.html.twig', array(
            'items' => $items,
        ));
    }

    /**
     * Creates a new item entity.
     *
     * @Route("/new/{reglement}", name="backend_item_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $reglement)
    {
        $item = new Item();
        $form = $this->createForm('AppBundle\Form\ItemType', $item, ['reglement'=>$reglement]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('backend_item_new', array('reglement' => $item->getReglement()->getSlug()));
        }
        $em = $this->getDoctrine()->getManager();
        $reglement = $em->getRepository("AppBundle:Reglement")->findOneBy(['slug'=>$reglement]);
        $items = $em->getRepository("AppBundle:Item")->findBy(['reglement'=>$reglement]);

        return $this->render('item/new.html.twig', array(
            'item' => $item,
            'items' => $items,
            'form' => $form->createView(),
            'reglement' => $reglement
        ));
    }

    /**
     * Finds and displays a item entity.
     *
     * @Route("/{id}", name="backend_item_show")
     * @Method("GET")
     */
    public function showAction(Item $item)
    {
        $deleteForm = $this->createDeleteForm($item);

        return $this->render('item/show.html.twig', array(
            'item' => $item,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing item entity.
     *
     * @Route("/{id}/edit", name="backend_item_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Item $item)
    {
        $deleteForm = $this->createDeleteForm($item);
        $editForm = $this->createForm('AppBundle\Form\ItemType', $item, ['reglement'=>$item->getReglement()->getSlug()]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_item_new', array('reglement' => $item->getReglement()->getSlug()));
        }
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository("AppBundle:Item")->findBy(['reglement'=>$item->getReglement()]);
        $reglement = $em->getRepository('AppBundle:Reglement')->findOneBy(['id'=>$item->getReglement()->getId()]);

        return $this->render('item/edit.html.twig', array(
            'item' => $item,
            'items' => $items,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'reglement' => $reglement
        ));
    }

    /**
     * Deletes a item entity.
     *
     * @Route("/{id}", name="backend_item_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Item $item)
    {
        $form = $this->createDeleteForm($item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
        }

        return $this->redirectToRoute('backend_item_index');
    }

    /**
     * Creates a form to delete a item entity.
     *
     * @param Item $item The item entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Item $item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_item_delete', array('id' => $item->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
