<?php

namespace Anar\SuperPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BlogType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'title',
                'required' => true,
                'attr' => array(
                    'pattern' => '.{4,255}',
                ),
            ))
            ->add('description', 'text', array(
                'label' => 'description',
                'required' => false,
                'attr' => array(
                    'maxlength' => 500,
                ),
            ))
            ->add('name', 'text', array(
                'label' => 'name',
                'required' => true,
                'attr' => array(
                    'pattern' => '^[a-z]{4,100}$',
                ),
            ))
            ->add('theme', 'entity', array(
                'class' => 'AnarEngineBundle:Theme',
                'property' => 'name',
                'label' => 'theme',
                'required' => true,
                'placeholder' => 'placeholder',
            ))
            ->add('onTree', 'checkbox', array(
                'label' => 'display.in.menu',
                'data' => true,
                'empty_data' => true,
            ))
            ->add('active', 'checkbox', array(
                'label' => 'is.active',
                'empty_data' => true,
                'data' => true,
            ))
            ->add('parent', 'entity', array(
                'class' => 'AnarEngineBundle:Blog',
                'property' => 'title',
                'label' => 'parent',
                'required' => true,
                'placeholder' => 'placeholder',
            ))
            ->add('apps', 'entity', array(
                'class' => 'AnarEngineBundle:App',
                'property' => 'title',
                'multiple' => true,
                'label' => 'facilities',
                'required' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\EngineBundle\Entity\Blog',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_enginebundle_blog';
    }
}
