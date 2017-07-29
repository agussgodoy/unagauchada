<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Postulacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Postulacion controller.
 *
 * @Route("postulacion")
 */
class PostulacionController extends Controller
{
    /**
     * Lists all postulacion entities.
     *
     * @Route("/", name="postulacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $postulacions = $em->getRepository('AppBundle:Postulacion')->findAll();

        return $this->render('postulacion/index.html.twig', array(
            'postulacions' => $postulacions,
        ));
    }

    /**
     * Creates a new postulacion entity.
     *
     * @Route("/new", name="postulacion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $postulacion = new Postulacion();
        $form = $this->createForm('AppBundle\Form\PostulacionType', $postulacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($postulacion);
            $em->flush();

            return $this->redirectToRoute('postulacion_show', array('id' => $postulacion->getId()));
        }

        return $this->render('postulacion/new.html.twig', array(
            'postulacion' => $postulacion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a postulacion entity.
     *
     * @Route("/{id}", name="postulacion_show")
     * @Method("GET")
     */
    public function showAction(Postulacion $postulacion)
    {
        $deleteForm = $this->createDeleteForm($postulacion);

        return $this->render('postulacion/show.html.twig', array(
            'postulacion' => $postulacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing postulacion entity.
     *
     * @Route("/{id}/edit", name="postulacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Postulacion $postulacion)
    {
        $deleteForm = $this->createDeleteForm($postulacion);
        $editForm = $this->createForm('AppBundle\Form\PostulacionType', $postulacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('postulacion_edit', array('id' => $postulacion->getId()));
        }

        return $this->render('postulacion/edit.html.twig', array(
            'postulacion' => $postulacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a postulacion entity.
     *
     * @Route("/{id}", name="postulacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Postulacion $postulacion)
    {
        $form = $this->createDeleteForm($postulacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($postulacion);
            $em->flush();
        }

        return $this->redirectToRoute('postulacion_index');
    }

    /**
     * Creates a form to delete a postulacion entity.
     *
     * @param Postulacion $postulacion The postulacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Postulacion $postulacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('postulacion_delete', array('id' => $postulacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
