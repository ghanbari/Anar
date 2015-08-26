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
                    'placeholder' => 'first.name',
                ),
            ))
            ->add('lname', 'text', array(
                'label' => 'last.name',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                    'placeholder' => 'last.name',
                ),
            ))
            ->add('faname', 'text', array(
                'label' => 'father.name',
                'required' => false,
                'attr' => array(
                    'maxlength' => 255,
                    'placeholder' => 'father.name',
                ),
            ))
            ->add('staffCode', 'number', array(
                'label' => 'staff.code',
                'required' => true,
                'attr' => array(
                    'placeholder' => 'staff.number',
                ),
            ))
            ->add('grade', 'entity', array(
                'class' => 'AnarEngineBundle:Grade',
                'property' => 'name',
                'label' => 'grade',
                'required' => true,
                'placeholder' => 'placeholder',
            ))
            ->add('username', 'text', array(
                'label' => 'username',
                'attr' => array(
                    'pattern' => '^[a-z0-9_]{2,255}$',
                    'placeholder' => 'username.consist.of.2-255.character.a-z0-9_',
                )
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'is.enabled',
                'required' => false,
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
