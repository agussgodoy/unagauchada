<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Favor;
use AppBundle\Entity\Comentario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Postulacion;


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

        $favors = $em->getRepository('AppBundle:Favor')->findBy(array('elegido'=>null));

        return $this->render('favor/index.html.twig', array(
            'favors' => $favors,
            'user' => $this->getUser()

        ));
    }


    /**
     *
     * @Route("/{id}/newPostularse", name="favor_newPostularse")
     * @Method({"GET", "POST"})
     */
    public function newPostulacionAction(Request $request, Favor $favor)
    {
        $em = $this->getDoctrine()->getManager();

        $postulacion = new Postulacion();
        $form = $this->createForm('AppBundle\Form\PostulacionType', $postulacion);
        $form->handleRequest($request);

        if($form->isValid()){
            $postulacion->setAutor($this->getUser());
            $postulacion->setFavor($favor);

            $em->persist($postulacion);
            $em->flush();

            return $this->redirectToRoute('favor_show', array('id' => $favor->getId()));
        }

        
        return $this->render('favor/postularse.html.twig', array(
            'favor' => $favor,
            'form'=>$form->createView(),
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
        $postulacion = new Postulacion();
        $form = $this->createForm('AppBundle\Form\PostulacionType', $postulacion);  
    
        return $this->render('favor/postularse.html.twig', array(
            'favor' => $favor,
            'form' =>$form->createView(),
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
    public function newBuscarAction(request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $favor = new Favor();
        $form = $this->createForm('AppBundle\Form\buscarFavorType', $favor);  
        $form->handleRequest($request);

        if($form->isValid()){
            $favor = $em->getRepository('AppBundle:Favor')->find($favor->getId());
            return $this->redirectToRoute('favor_show', array('id' => $favor->getId()));
        }

        return $this->render('favor/newBuscar.html.twig', array(
            'form' => $form,
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
            $favor->uploadFoto($this->container->getParameter('dir.favor.fotos'));
            $this->getUser()->setCreditos($this->getUser()->getCreditos()-1);
            $em->persist($this->getUser());
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
     * @Route("/{id}/show", name="favor_show")
     * @Method("GET")
     */
    public function showAction(Favor $favor)
    {
        return $this->render('favor/show.html.twig', array(
            'favor' => $favor,
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
        if(count($favor->getCandidatos()) != 0){
            $session = $this->getRequest()->getSession();
            $session->getFlashBag()->add('aviso_error', 'No puedes editar por que ya tienes candidatos!');
            return $this->redirectToRoute('usuario_misFavores', array('id' => $favor->getAutor()->getId()));
        }

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


    /**
     * Displays a form to edit an existing favor entity.
     *
     * @Route("/{id}/{idusuario}/elegir", name="favor_elegir")
     * @Method({"GET"})
     */
    public function elegirAction(Favor $favor, $idusuario)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $em->getRepository('AppBundle:Usuario')->find($idusuario);
        $session = $this->getRequest()->getSession();
        
        $favor->setElegido($usuario);
        $em->persist($favor);
        $em->flush();

        /*$titulo = $favor->getTitulo();
        $mailElegido = $favor->getElegido()->getEmail();
        $nombreElegido= $favor->getElegido()->getNombre();

        $mailAutor = $favor->getAutor()->getEmail();
        $nombreAutor = $favor->getAutor()->getNombre();

        $this->enviarMail($titulo, $mailElegido, $nombreElegido, $mailAutor, $nombreAutor);*/

        $session->getFlashBag()->add('aviso_exito', 'Se ha seleccionado al elegido con éxito.');
        // return $this->redirectToRoute('favor_index');
        return $this->redirectToRoute('usuario_showElegido', array('id' => $favor->getElegido()->getId()));

    }




    public function enviarMail($titulo, $mailElegido, $nombreElegido, $mailAutor, $nombreAutor)
    {
        // $template = 'unagauchada:resources:notificacion.html.twig';
        // $template2 = 'AppBundle:Favor:notificacion2.html.twig';
        // $args = array(
        //     'titulo' => $titulo,
        //     'mailElegido' => $mailElegido,
        //     'nombreElegido' => $nombreElegido,
        //     'mailAutor' => $mailAutor,
        //     'nombreAutor' => $nombreAutor
        //     );
        // $message = \Swift_Message::newInstance()
        //     ->setSubject("Has sido elegido para un favor!")
        //     ->setFrom(array('unagauchadaadm@gmail.com' => 'unagauchada'))
        //     ->setTo(array($mailElegido))
        //     ->setBody(
        //         $this->renderView(
        //             $template,
        //             $args
        //         ),
        //         'text/html'
        //     );
        // $message2 = \Swift_Message::newInstance()
        //     ->setSubject("Has elegido a alguien para cumplir tu favor!")
        //     ->setFrom(array('unagauchadaadm@gmail.com' => 'unagauchada'))
        //     ->setTo(array($mailAutor))
        //     ->setBody(
        //         $this->renderView(
        //             $template2,
        //             $args
        //         ),
        //         'text/html'
        //     );
        // try {
        //     $this->get('mailer')->send($message);
        //     $this->getRequest()->getSession()->getFlashBag()->add('aviso_exito',
        //             'Notificación enviada.');
        // } catch (\Exception $e) {
        //      $this->getRequest()->getSession()->getFlashBag()->add('aviso_error',
        //             'No se pudo enviar el mail.');
        // }
    }

}
