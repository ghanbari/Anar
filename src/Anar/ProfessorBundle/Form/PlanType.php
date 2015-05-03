<?php

namespace Anar\ProfessorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class PlanType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hours = array(7,8,9,10,11,12,13,14,15,16,17,18,19,20);
        $minutes = array(0,5,10,15,20,25,30,35,40,45,50,55);

        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'title',
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('startTime', 'time', array(
                'label' => 'time',
                'required' => true,
                'hours' => $hours,
                'minutes' => $minutes,
                'translation_domain' => false,
            ))
            ->add('endTime', 'time', array(
                'label' => 'time',
                'required' => true,
                'hours' => $hours,
                'minutes' => $minutes,
                'translation_domain' => false,
            ))
            ->add('dayNumber', 'choice', array(
                'label' => 'week.day',
                'required' => true,
                'choices' => array(
                    '0' => 'saturday',
                    '1' => 'sunday',
                    '2' => 'monday',
                    '3' => 'tuesday',
                    '4' => 'wednesday',
                    '5' => 'thursday',
                    '6' => 'friday',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setConfigure(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\ProfessorBundle\Entity\Plan',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_professorbundle_plan';
    }
}
