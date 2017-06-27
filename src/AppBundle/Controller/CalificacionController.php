<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calificacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Calificacion controller.
 *
 * @Route("calificacion")
 */
class CalificacionController extends Controller
{
    /**
     * Lists all calificacion entities.
     *
     * @Route("/", name="calificacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $calificaciones = $em->getRepository('AppBundle:Calificacion')->findAll();

        return $this->render('calificacion/index.html.twig', array(
            'calificaciones' => $calificaciones,
        ));
    }

    /**
     * Creates a new calificacion entity.
     *
     * @Route("/new", name="calificacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $calificacion = new Calificacion();
        $form = $this->createForm('AppBundle\Form\CalificacionType', $calificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificacion);
            $em->flush();

            return $this->redirectToRoute('calificacion_show', array('id' => $calificacion->getId()));
        }

        return $this->render('calificacion/new.html.twig', array(
            'calificacion' => $calificacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a calificacion entity.
     *
     * @Route("/{id}", name="calificacion_show")
     * @Method("GET")
     */
    public function showAction(Calificacion $calificacion)
    {
        $deleteForm = $this->createDeleteForm($calificacion);

        return $this->render('calificacion/show.html.twig', array(
            'calificacion' => $calificacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing calificacion entity.
     *
     * @Route("/{id}/edit", name="calificacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Calificacion $calificacion)
    {
        $deleteForm = $this->createDeleteForm($calificacion);
        $editForm = $this->createForm('AppBundle\Form\CalificacionType', $calificacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('calificacion_edit', array('id' => $calificacion->getId()));
        }

        return $this->render('calificacion/edit.html.twig', array(
            'calificacion' => $calificacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a calificacion entity.
     *
     * @Route("/{id}", name="calificacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Calificacion $calificacion)
    {
        $form = $this->createDeleteForm($calificacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calificacion);
            $em->flush();
        }

        return $this->redirectToRoute('calificacion_index');
    }

    /**
     * Creates a form to delete a calificacion entity.
     *
     * @param Calificacion $calificacion The calificacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Calificacion $calificacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calificacion_delete', array('id' => $calificacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
