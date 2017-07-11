<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array(
                'label' => 'Mail',
                'required' => true))
            // ->add('isActive')
            /*->add('rol')
            ->add('createdAt')*/
            ->add('nombre', 'text', array(
                'label'=> 'Nombre',
                'required'=>true))
            ->add('apellido', 'text', array(
                'label'=>'Apellido' ,
                'required'=>true))
            ->add('telefono', 'text', array(
                'label'=>'Telefono' ,
                'required'=>true))
            ->add('password', 'password', array(
                'label' => 'Contraseña',
                'required'=> true))
/*            ->add('creditos')
            ->add('puntaje')
            ->add('postulaciones')*/
            ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_usuario';
    }


}
