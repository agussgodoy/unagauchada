<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FavorType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titulo', 'text', array(
            'label'=>'Título'))
        ->add('detalle', 'textarea', array(
            'label'=>'Descripción'))
        ->add('categoria', null, array(
            'label'=>'Categoría',
            'empty_value'=>'Seleccione'))
        ->add('localidad', 'text', array(
            'label'=>'Localidad'));
        //->add('elegido')
        //->add('autor');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Favor'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_favor';
    }


}
