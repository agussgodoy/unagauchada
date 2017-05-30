<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Usuario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
     * @Route("/", name="usuario_index")
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
                    'min'=>1)))
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

            return $this->redirectToRoute('usuario_edit', array('id' => $usuario->getId()));
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
}
