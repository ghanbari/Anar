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
            ->add('username', 'text', array('required' => false))
            ->add('email', 'email', array('required' => false))
            ->add('fname', 'text', array('required' => false))
            ->add('lname', 'text', array('required' => false))
            ->add('staffCode', 'number', array('required' => false))
            ->add('grade', 'entity', array(
                'class' => 'AnarEngineBundle:Grade',
                'property' => 'name'
            ))
            ->add('enabled', 'checkbox', array('required' => false))
            ->add('expired', 'checkbox', array('required' => false));
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