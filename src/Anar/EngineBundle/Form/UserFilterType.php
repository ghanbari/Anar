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
                'attr' => array(
                    'placeholder' => 'find.user.with.this.username',
                )
            ))
            ->add('email', 'email', array(
                'required' => false,
                'label' => 'email',
                'attr' => array(
                    'placeholder' => 'find.user.with.this.email',
                )
            ))
            ->add('fname', 'text', array(
                'required' => false,
                'label' => 'fname',
                'attr' => array(
                    'placeholder' => 'find.users.with.this.fname.and.lname',
                )
            ))
            ->add('lname', 'text', array(
                'required' => false,
                'label' => 'lname',
                'attr' => array(
                    'placeholder' => 'find.users.with.this.fname.and.lname',
                )
            ))
            ->add('staffCode', 'number', array(
                'required' => false,
                'label' => 'staff.code',
                'attr' => array(
                    'placeholder' => 'find.users.with.this.code',
                )
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