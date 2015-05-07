<?php

namespace Anar\EngineBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserFilterType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'required' => false,
                'label' => 'username',
            ))
            ->add('email', 'email', array(
                'required' => false,
                'label' => 'email',
            ))
            ->add('fname', 'text', array(
                'required' => false,
                'label' => 'fname',
            ))
            ->add('lname', 'text', array(
                'required' => false,
                'label' => 'lname',
            ))
            ->add('staffCode', 'number', array(
                'required' => false,
                'label' => 'staff.code',
            ))
            ->add('grade', 'entity', array(
                'label' => 'grade',
                'class' => 'AnarEngineBundle:Grade',
                'property' => 'name',
                'placeholder' => 'placeholder',
                'required' => false,
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'data' => true,
                'label' => 'enabled',
            ))
            ->add('expired', 'checkbox', array(
                'required' => false,
                'label' => 'expired',
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'forms',
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'user_search';
    }
}