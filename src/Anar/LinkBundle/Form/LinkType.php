<?php

namespace Anar\LinkBundle\Form;

use Anar\LinkBundle\Entity\Link;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'required' => true,
                'label' => 'title',
                'attr' => array(
                    'maxlength' => 255
                ),
            ))
            ->add('description', 'textarea', array(
                'required' => false,
                'label' => 'description',
            ))
            ->add('url', 'url', array(
                'required' => true,
                'label' => 'url',
            ))
            ->add('position', 'choice', array(
                'label' => 'position.in.page',
                'required' => true,
                'choices' => Link::getAvailablePosition(),
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOption(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\LinkBundle\Entity\Link',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_linkbundle_link';
    }
}
