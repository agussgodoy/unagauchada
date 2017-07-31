<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Compra;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Compra controller.
 *
 * @Route("compra")
 */
class CompraController extends Controller
{
    /**
     * Lists all compra entities.
     *
     * @Route("/", name="compra_index")
     * @Method("GET|POST")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $compras = array();
        $form = $form = $this->createFormBuilder()
            ->add('desde','date', array(
                'label'=>'Fecha desde',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'invalid_message' => 'Fecha incorrecta (dd/mm/aaaa)',
                'attr'=>array(
                    'class'=>'fecha')))
            ->add('hasta','date', array(
                'label'=>'Fecha hasta',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'invalid_message' => 'Fecha incorrecta (dd/mm/aaaa)',
                'attr'=>array(
                   'class'=>'fecha' )))
            ->add('submit', SubmitType::class, array('label' => 'Buscar'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $compras = $em->getRepository('AppBundle:Compra')->buscar($form->get('desde')->getData(), $form->get('hasta')->getData());
        }

        return $this->render('compra/index.html.twig', array(
            'compras' => $compras,
            'form'=>$form->createView()
        ));
    }

    /**
     * Finds and displays a compra entity.
     *
     * @Route("/{id}", name="compra_show")
     * @Method("GET")
     */
    public function showAction(Compra $compra)
    {

        return $this->render('compra/show.html.twig', array(
            'compra' => $compra,
        ));
    }
}
