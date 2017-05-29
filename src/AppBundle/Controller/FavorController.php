<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Favor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Favor controller.
 *
 * @Route("favor")
 */
class FavorController extends Controller
{
    /**
     * Lists all favor entities.
     *
     * @Route("/", name="favor_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $favors = $em->getRepository('AppBundle:Favor')->findAll();

        return $this->render('favor/index.html.twig', array(
            'favors' => $favors,
            'user' => $this->getUser()

        ));
    }


    /**
     *
     * @Route("/{id}/postularse", name="favor_postularse")
     * @Method({"GET", "POST"})
     */
    public function postularseAction(Request $request, Favor $favor)
    {
        $em = $this->getDoctrine()->getManager();
        $favors = $em->getRepository('AppBundle:Favor')->findAll();

        $favor->addCandidato($this->getUser());
        $em->persist($favor);
        $em->flush();

    
        return $this->render('favor/postularse.html.twig', array(
            'favors' => $favors,
            'user' => $this->getUser(),
            'favor' => $favor
            ));
    }



    /**
     *
     * @Route("/{id}/despostularse", name="favor_despostularse")
     * @Method({"GET", "POST"})
     */
    public function despostularseAction(Request $request, Favor $favor)
    {
        $em = $this->getDoctrine()->getManager();
        $favors = $em->getRepository('AppBundle:Favor')->findAll();

        $favor->removeCandidato($this->getUser());
        $em->persist($favor);
        $em->flush();
    
        return $this->render('favor/despostularse.html.twig', array(
            'favors' => $favors,
            'user' => $this->getUser(),
            'favor' => $favor
            ));
    }



    /**
     *
     * @Route("/newBuscar", name="favor_newBuscar")
     * @Method({"GET", "POST"})
     */
    public function newBuscarAction()
    {
        $em = $this->getDoctrine()->getManager();

        $favors = $em->getRepository('AppBundle:Favor')->findAll();

        return $this->render('favor/newBuscar.html.twig', array(
            'favors' => $favors,
        ));
    }



    /**
     *
     * @Route("/buscar/{id}", name="favor_buscar")
     * @Method({"GET", "POST"})
     */
    public function buscarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $favor = $em->getRepository('AppBundle:Favor')->findOneBy((array('id' => $id)));

        return $this->render('favor/show.html.twig', array(
            'favor' => $favor,
        ));
    }


    /**
     * Creates a new favor entity.
     *
     * @Route("/new", name="favor_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $favor = new Favor();
        $form = $this->createForm('AppBundle\Form\FavorType', $favor);
        $form->handleRequest($request);
        $favor->setAutor($this->getUser());
        $favor->setElegido(null);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($favor);
            $em->flush();

            return $this->redirectToRoute('favor_show', array('id' => $favor->getId()));
        }

        return $this->render('favor/new.html.twig', array(
            'favor' => $favor,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a favor entity.
     *
     * @Route("/{id}", name="favor_show")
     * @Method("GET")
     */
    public function showAction(Favor $favor)
    {
        $deleteForm = $this->createDeleteForm($favor);

        return $this->render('favor/show.html.twig', array(
            'favor' => $favor,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing favor entity.
     *
     * @Route("/{id}/edit", name="favor_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Favor $favor)
    {
        $deleteForm = $this->createDeleteForm($favor);
        $editForm = $this->createForm('AppBundle\Form\FavorType', $favor);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('favor_show', array('id' => $favor->getId()));
        }

        return $this->render('favor/edit.html.twig', array(
            'favor' => $favor,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a favor entity.
     *
     * @Route("/{id}", name="favor_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Favor $favor)
    {
        $form = $this->createDeleteForm($favor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($favor);
            $em->flush();
        }

        return $this->redirectToRoute('favor_index');
    }

    /**
     * Creates a form to delete a favor entity.
     *
     * @param Favor $favor The favor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Favor $favor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('favor_delete', array('id' => $favor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
