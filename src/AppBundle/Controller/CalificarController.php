<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Calificar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Calificar controller.
 *
 * @Route("calificar")
 */
class CalificarController extends Controller
{
    /**
     * Lists all calificar entities.
     *
     * @Route("/", name="calificar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $calificaciones = $em->getRepository('AppBundle:Calificar')->findAll();

        return $this->render('calificar/index.html.twig', array(
            'calificaciones' => $calificaciones,
        ));
    }

    /**
     * Creates a new calificar entity.
     *
     * @Route("/new", name="calificar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $calificar = new Calificar();
        $form = $this->createForm('AppBundle\Form\CalificarType', $calificar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($calificar);
            $em->flush();

            return $this->redirectToRoute('calificar_index', array('id' => $calificar->getId()));
        }

        return $this->render('calificar/new.html.twig', array(
            'calificar' => $calificar,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a calificar entity.
     *
     * @Route("/{id}", name="calificar_show")
     * @Method("GET")
     */
    public function showAction(Calificar $calificar)
    {
        $deleteForm = $this->createDeleteForm($calificar);

        return $this->render('calificar/show.html.twig', array(
            'calificar' => $calificar,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing calificar entity.
     *
     * @Route("/{id}/edit", name="calificar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Calificar $calificar)
    {
        $deleteForm = $this->createDeleteForm($calificar);
        $editForm = $this->createForm('AppBundle\Form\CalificarType', $calificar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $session = $this->getRequest()->getSession();
            $session->getFlashBag()->add('aviso_exito', 'Se ha modificado la calificación con éxito');

            return $this->redirectToRoute('calificar_index', array('id' => $calificar->getId()));
        }

        return $this->render('calificar/edit.html.twig', array(
            'calificar' => $calificar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a calificar entity.
     *
     * @Route("/{id}", name="calificar_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Calificar $calificar)
    {
        $form = $this->createDeleteForm($calificar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($calificar);
            $em->flush();
        }

        return $this->redirectToRoute('calificar_index');
    }

    /**
     * Creates a form to delete a calificar entity.
     *
     * @param Calificar $calificar The calificar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Calificar $calificar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('calificar_delete', array('id' => $calificar->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


    /**
     * Deletes a calificar entity.
     *
     * @Route("/{id}/eliminar", name="calificar_eliminar")
     * @Method("GET")
     */
    public function eliminarAction(Calificar $calificar)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($calificar);
        $em->flush();
        $calificaciones = $em->getRepository('AppBundle:Calificar')->findAll();

        $session = $this->getRequest()->getSession();
        $session->getFlashBag()->add('aviso_exito', 'Se ha eliminado la calificación con éxito');

        return $this->render('calificar/index.html.twig', array(
            'calificaciones' => $calificaciones,

        ));
    }

}
