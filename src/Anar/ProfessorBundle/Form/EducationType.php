<?php

namespace Anar\ProfessorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EducationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('university', 'text', array(
                'label' => 'university',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('city', 'text', array(
                'label' => 'city',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('country', 'text', array(
                'label' => 'country',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('startDate', 'date', array(
                'label' => 'from.date',
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd',
                'translation_domain' => false,
            ))
            ->add('endDate', 'date', array(
                'label' => 'to.date',
                'required' => true,
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd',
                'translation_domain' => false,
            ))
            ->add('grade', 'entity', array(
                'label' => 'grade',
                'required' => true,
                'placeholder' => 'placeholder',
                'class' => 'Anar\EngineBundle\Entity\Grade',
                'property' => 'name',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\ProfessorBundle\Entity\Education',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_professorbundle_education';
    }
}
