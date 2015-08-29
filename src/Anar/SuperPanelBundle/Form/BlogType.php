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
                    'placeholder' => 'title.your.site.wordage.between.4-255.word',
                ),
            ))
            ->add('description', 'textarea', array(
                'label' => 'description',
                'required' => false,
                'attr' => array(
                    'maxlength' => 500,
                    'placeholder' => 'max.500.letter',
                ),
            ))
            ->add('name', 'text', array(
                'label' => 'name',
                'required' => true,
                'attr' => array(
                    'pattern' => '^[a-z]{4,100}$',
                    'placeholder' => 'lowercase.a-z.between.4-100',
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
                'required' => false,
            ))
            ->add('active', 'checkbox', array(
                'label' => 'is.active',
                'required' => false,
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
                'query_builder' => function ($er) {
                    $qb = $er->createQueryBuilder('a');
                    return $qb->where($qb->expr()->neq('a.type', "'system'"));
                }
            ))
            ->add('driveSize', 'number', array(
                'label' => 'drive.size',
                'required' => true,
                'grouping' => true,
                'attr' => array(
                    'placeholder' => 'drive.size.in.mb',
                ),
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
