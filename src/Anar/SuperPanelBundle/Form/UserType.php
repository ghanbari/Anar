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
            ->add('fname', 'text')
            ->add('lname', 'text')
            ->add('faname', 'text')
            ->add('staffCode', 'number')
            ->add('grade', 'entity', array(
                'class' => 'AnarEngineBundle:Grade',
                'property' => 'name'
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\EngineBundle\Entity\User'
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
