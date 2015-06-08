<?php

namespace Anar\ContactBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'label' => 'name',
                'required' => true,
            ))
            ->add('email', 'email', array(
                'label' => 'email',
                'required' => false,
            ))
            ->add('website', 'url', array(
                'label' => 'website',
                'required' => false,
            ))
            ->add('message', 'textarea', array(
                'label' => 'message',
                'required' => true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\ContactBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_contactbundle_contact';
    }
}
