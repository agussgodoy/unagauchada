<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Doctrine\ORM\EntityRepository;


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
        ->add('categoria', 'entity', array(
            'class'=>'AppBundle:Categoria',
            'label'=>'Categoría',
            'empty_value'=>'Seleccione',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('c')
                        ->where('c.isActive = 1');
            },

            ))
        ->add('foto', FileType::class, array(
            'required'=>false))
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
