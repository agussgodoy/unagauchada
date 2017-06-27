<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Reputacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Reputacion controller.
 *
 * @Route("reputacion")
 */
class ReputacionController extends Controller
{
    /**
     * Lists all reputacion entities.
     *
     * @Route("/", name="reputacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reputacions = $em->getRepository('AppBundle:Reputacion')->findAll();

        return $this->render('reputacion/index.html.twig', array(
            'reputacions' => $reputacions,
        ));
    }

    /**
     * Creates a new reputacion entity.
     *
     * @Route("/new", name="reputacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $reputacion = new Reputacion();
        $form = $this->createForm('AppBundle\Form\ReputacionType', $reputacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reputacion);
            $em->flush();

            return $this->redirectToRoute('reputacion_show', array('id' => $reputacion->getId()));
        }

        return $this->render('reputacion/new.html.twig', array(
            'reputacion' => $reputacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a reputacion entity.
     *
     * @Route("/{id}", name="reputacion_show")
     * @Method("GET")
     */
    public function showAction(Reputacion $reputacion)
    {
        $deleteForm = $this->createDeleteForm($reputacion);

        return $this->render('reputacion/show.html.twig', array(
            'reputacion' => $reputacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reputacion entity.
     *
     * @Route("/{id}/edit", name="reputacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Reputacion $reputacion)
    {
        $deleteForm = $this->createDeleteForm($reputacion);
        $editForm = $this->createForm('AppBundle\Form\ReputacionType', $reputacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reputacion_edit', array('id' => $reputacion->getId()));
        }

        return $this->render('reputacion/edit.html.twig', array(
            'reputacion' => $reputacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reputacion entity.
     *
     * @Route("/{id}", name="reputacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Reputacion $reputacion)
    {
        $form = $this->createDeleteForm($reputacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reputacion);
            $em->flush();
        }

        return $this->redirectToRoute('reputacion_index');
    }

    /**
     * Creates a form to delete a reputacion entity.
     *
     * @param Reputacion $reputacion The reputacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reputacion $reputacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reputacion_delete', array('id' => $reputacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}