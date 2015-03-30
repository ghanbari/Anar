<?php

namespace Anar\SuperPanelBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fname', 'text', array(
                'label' => 'first.name',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('lname', 'text', array(
                'label' => 'last.name',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('faname', 'text', array(
                'label' => 'father.name',
                'required' => false,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('staffCode', 'number', array(
                'label' => 'staff.code',
                'required' => true,
                'attr' => array(
                    'pattern' => '\d+',
                ),
            ))
            ->add('grade', 'entity', array(
                'class' => 'AnarEngineBundle:Grade',
                'property' => 'name',
                'label' => 'grade',
                'required' => true,
                'placeholder' => 'placeholder',
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\EngineBundle\Entity\User',
            'translation_domain' => 'forms',
        ));
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'super_panel_user_registraton';
    }
}
