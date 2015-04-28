<?php

namespace Anar\ProfessorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentsDissertationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', 'text', array(
                'label' => 'author',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                )
            ))
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'title',
                'attr' => array(
                    'maxlength' => 255,
                )
            ))
            ->add('grade', 'entity', array(
                'label' => 'grade',
                'required' => true,
                'class' => 'Anar\EngineBundle\Entity\Grade',
                'property' => 'name',
            ))
            ->add('abstract', 'textarea', array(
                'label' => 'abstract',
                'required' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setConfigure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\ProfessorBundle\Entity\StudentsDissertation',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_professorbundle_studentsdissertation';
    }
}
