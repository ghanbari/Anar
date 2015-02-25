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
            ->add('title', 'text')
            ->add('description', 'text')
            ->add('name', 'text')
            ->add('theme', 'entity', array(
                'class' => 'AnarEngineBundle:Theme',
                'property' => 'name',
            ))
            ->add('onTree', 'checkbox')
            ->add('active', 'checkbox')
            ->add('parent', 'entity', array(
                'class' => 'AnarEngineBundle:Blog',
                'property' => 'title',
            ))
            ->add('apps', 'entity', array(
                'class' => 'AnarEngineBundle:App',
                'property' => 'title',
                'multiple' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\EngineBundle\Entity\Blog'
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
