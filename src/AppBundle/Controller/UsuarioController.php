<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use AppBundle\Entity\Postulacion;
use AppBundle\Entity\Favor;
use AppBundle\Entity\Calificacion;

/**
 * Usuario controller.
 *
 * @Route("usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lists all usuario entities.
     *
     * @Route("/rankingUsuarios", name="usuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('AppBundle:Usuario')->findAll();

        return $this->render('usuario/index.html.twig', array(
            'usuarios' => $usuarios,
        ));
    }



    /**
     * Lists all usuario entities.
     *
     * @Route("/{id}/newComprar", name="usuario_newComprar")
     * @Method({"GET", "POST"})
     */
    public function newComprarAction(Request $request, Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();
        
        $form = $this->createFormBuilder()
            ->add('cantidad','integer', array(
                'label'=>'Cantidad',
                'attr'=>array(
                    'min'=>1)))
            ->add('tarjeta','integer', array(
                'label'=>'Tarjeta',
                'attr'=>array(
                    'min'=>1)))
            ->add('codigo','integer', array(
                'label'=>'Código de Seguridad',
                'attr'=>array(
                    'min'=>1, 
                    )))
            ->add('titular','text', array(
                'label'=>'Titular'))
            ->add('mesVencimiento','integer', array(
                'label'=>'Vencimiento',
                'attr'=>array(
                    'min'=>1,
                    'max'=>12, 
                    'placeholder'=>'Mes')))
            ->add('anioVencimiento','integer', array(
                'label'=>'',
                'attr'=>array(
                    'min'=>2017,
                    'max'=>2050,
                    'placeholder'=>'Año')))
            ->add('submit', SubmitType::class, array('label' => 'Comprar'))
            ->getForm();
        $form->handleRequest($request);
        
         if ($form->isSubmitted() && $form->isValid()) {
            $session = $this->getRequest()->getSession();
            $em = $this->getDoctrine()->getManager();
            
            $usuario->setCreditos($usuario->getCreditos() + $form->get('cantidad')->getData());
            $em->persist($usuario);
            $em->flush();

            $session->getFlashBag()->add('aviso_exito', 'La compra se realizó con éxito');

            return $this->redirectToRoute('usuario_show', array('id' => $usuario->getId()));
        }
        return $this->render('usuario/newComprar.html.twig', array(
            'usuario' => $this->getUser(),
            'form'=>$form->createView()
        ));
    }






    /**
     * Creates a new usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $usuario = new Usuario();
        $form = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $session = $this->getRequest()->getSession();
            $em = $this->getDoctrine()->getManager();

            if($em->getRepository('AppBundle:Usuario')->existeUsuario($form->get('email')->getData(),$form->get('apellido')->getData(),$form->get('nombre')->getData() > 0 )){
                $session->getFlashBag()->add('aviso_error', 'Ya existe un usuario con el mismo mail o con el mismo nombre y apellido.');
                return $this->redirectToRoute('usuario_new');
            }else{
                $em->persist($usuario);
                $em->flush();

                $session->getFlashBag()->add('aviso_exito', 'El usuario fue creado correctamente. Ahora puede iniciar sesión.');
            }


            return $this->redirectToRoute('login');
        }

        return $this->render('usuario/new.html.twig', array(
            'usuario' => $usuario,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a usuario entity.
     *
     * @Route("/{id}/show", name="usuario_show")
     * @Method("GET")
     */
    public function showAction(Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);

        return $this->render('usuario/show.html.twig', array(
            'usuario' => $usuario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing usuario entity.
     *
     * @Route("/{id}/edit", name="usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Usuario $usuario)
    {
        $deleteForm = $this->createDeleteForm($usuario);
        $editForm = $this->createForm('AppBundle\Form\UsuarioType', $usuario);
        $editForm->handleRequest($request);
        
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $session = $this->getRequest()->getSession();
            $session->getFlashBag()->add('aviso_exito', 'Se han modificado tus datos.');

            return $this->redirectToRoute('usuario_show', array('id' => $usuario->getId()));
        }

        return $this->render('usuario/edit.html.twig', array(
            'usuario' => $usuario,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a usuario entity.
     *
     * @Route("/{id}", name="usuario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Usuario $usuario)
    {
        $form = $this->createDeleteForm($usuario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($usuario);
            $em->flush();
        }

        return $this->redirectToRoute('usuario_index');
    }

    /**
     * Creates a form to delete a usuario entity.
     *
     * @param Usuario $usuario The usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }



    /**
     *
     * @Route("/{id}/misPostulaciones", name="usuario_misPostulaciones")
     * @Method("GET")
     */
    public function misPostulacionesAction(Usuario $usuario)
    {
        $postulaciones = $usuario->getPostulaciones();

        return $this->render('usuario/misPostulaciones.html.twig', array(
            'usuario' => $usuario,
            'postulaciones' => $postulaciones,
        ));
    }

    /**
     *
     * @Route("/{id}/misCandidaturas", name="usuario_misCandidaturas")
     * @Method("GET")
     */
    public function miscandidaturasAction(Usuario $usuario)
    {
        $em = $this->getDoctrine()->getManager();

        $candidaturas = $em->getRepository('AppBundle:Favor')->findCandidaturas($usuario->getId());

        return $this->render('usuario/misCandidaturas.html.twig', array(
            'usuario' => $usuario,
            'candidaturas' => $candidaturas,
        ));
    }


    /**
     *
     * @Route("/{id}/eliminarPostulacion", name="usuario_eliminarPostulacion")
     * @Method("GET")
     */
    public function eliminarPostulacionAction(Postulacion $postulacion)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($postulacion);
        $em->flush();

        $usuario = $postulacion->getAutor();
        $postulaciones = $usuario->getPostulaciones();
        $session = $this->getRequest()->getSession();

        $session->getFlashBag()->add('aviso_exito', 'Te despostulaste con éxito del favor.');

        return $this->render('usuario/misPostulaciones.html.twig', array(
            'usuario' => $usuario,
            'postulaciones' => $postulaciones,
        ));
    }


    /**
     *
     * @Route("/{id}/misFavores", name="usuario_misFavores")
     * @Method("GET")
     */
    public function misfavoresAction(Usuario $usuario)
    {
        $favores = $usuario->getFavores();

        return $this->render('usuario/misFavores.html.twig', array(
            'usuario' => $usuario,
            'favores' => $favores,
        ));
    }

    /**
     * Deletes a favor entity.
     *
     * @Route("/{id}", name="usuario_eliminarFavor")
     * @Method("GET")
     */
    public function eliminarFavorAction(Favor $favor)
    {
        $session = $this->getRequest()->getSession();

        if($favor->getElegido() == null){
            $em = $this->getDoctrine()->getManager();
            $em->remove($favor);
            $em->flush();
            $session->getFlashBag()->add('aviso_exito', 'Se ha eliminado el favor con éxito');
        }
        else{
            $session->getFlashBag()->add('aviso_error', 'El favor ya tiene un elegido! No se puede eliminar.');
        }

        return $this->redirectToRoute('usuario_misFavores', array('id' => $this->getUser()->getId() ));
    }

    /**
     *
     * @Route("/{id}/showElegido", name="usuario_showElegido")
     * @Method("GET|POST")
     */
    public function showElegidoAction(Request $request, Favor $favor)
    {
        $em = $this->getDoctrine()->getManager();
        $usuario = $favor->getElegido();
        $autor = $favor->getAutor();
        $descripcion = 'Sin calificación';
        $form = $this->createFormBuilder()
            ->add('calificacion','entity', array(
                'class' => 'AppBundle:Calificar',
                'label'=>'Calificación',
                'empty_value' => '-Seleccione-'
                ))
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() && $favor->getCalificado() != 's') {
            $calificacion = new Calificacion;
            $calificacion->setPuntaje($form->getData()['calificacion']->getPuntos());
            $calificacion->setUsuarioAutor($autor);
            $calificacion->setUsuarioCalificado($usuario);
            $calificacion->setFavor($favor);
            $descripcion = $form->getData()['calificacion']->getDescripcion();
            $favor->setCalificado('s');
            // dump($favor);die;
            
            $usuario->addCalificacionesRecibidas($calificacion);
            $usuario->setPuntaje($usuario->getPuntaje() + $form->getData()['calificacion']->getPuntos());
            
            $autor->addCalificacionesDadas($calificacion);
            $favor->setCalificado('s');
            $em->persist($calificacion);
            $em->persist($favor);
            $em->persist($usuario);
            $em->flush();
            // var_dump($favor->getCalificado());

            $session = $this->getRequest()->getSession();
            $session->getFlashBag()->add('aviso_exito', 'Se ha calificado al usuario '.$usuario->getNombre().
                ' con éxito');
        }

        return $this->render('usuario/showElegido.html.twig', array(
                'usuario' => $usuario,
                'form' => $form->createView(),
                'calificado' => $favor->getCalificado(),
                'calificacion' => $descripcion
            ));
    }

}
