<?php

namespace Anar\LinkBundle\Form;

use Anar\LinkBundle\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'required' => false,
                'label' => 'category',
                'attr' => array(
                    'maxlength' => '255',
                )
            ))
            ->add('position', 'choice', array(
                'required' => true,
                'label' => 'position',
                'choices' => Category::getAvailablePosition(),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOption(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\LinkBundle\Entity\Category',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_linkbundle_Category';
    }
}
