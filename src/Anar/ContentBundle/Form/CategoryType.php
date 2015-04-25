<?php

namespace Anar\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
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
                    'maxlength' => 255,
                ),
            ))
            ->add('description', 'textarea', array(
                'label' => 'description',
                'required' => false,
                'attr' => array(
                    'maxlength' => 500,
                ),
            ))
            ->add('slug', 'text', array(
                'label' => 'slug',
                'required' => true,
                'attr' => array(
                    'pattern' => '[a-zA-Z0-9_]{0,255}',
                ),
            ))
            ->add('parent', 'entity', array(
                'label' => 'parent',
                'required' => false,
                'class' => 'Anar\ContentBundle\Entity\Category',
                'property' => 'title',
                'placeholder' => 'placeholder',
                'empty_value' => null,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\ContentBundle\Entity\Category',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_contentbundle_category';
    }
}
