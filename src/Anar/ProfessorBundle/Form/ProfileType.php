<?php

namespace Anar\ProfessorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Image;

class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('telephone', 'number', array(
                'required' => false,
                'label' => 'telephone',
                'attr' => array(
                    'placeholder' => 'number.between.11-15.digit.ex.989303334444',
                ),
            ))
            ->add('email', 'email', array(
                'required' => false,
                'label' => 'email',
                'attr' => array(
                  'maxlength' => '255'
                ),
            ))
            ->add('birthday', 'birthday', array(
                'required' => false,
                'label' => 'birthday',
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd',
                'translation_domain' => false,
            ))
            ->add('website', 'url', array(
                'required' => false,
                'label' => 'website',
                'attr' => array(
                  'maxlength' => 255
                ),
            ))
            ->add('avatarFile', 'file', array(
                'required'      => false,
                'constraints' => new Image(array(
                    'minWidth' => 10
                )),
                'attr' => array(
                    'class' => 'default',
                ),
            ))
            ->add('bio', 'textarea', array(
                'label' => 'bio',
                'required' =>false,
                'attr' => array(
                    'maxlength' => 10000
                )
            ))
            ->add('jobStartedAt', 'date', array(
                'label' => 'begin.date.of.job',
                'required' => false,
                'widget' => 'single_text',
                'format' => 'yyyy/MM/dd',
                'translation_domain' => false,
            ))
            ->add('skill', 'textarea', array(
                'label' => 'skill',
                'required' => false,
                'attr' => array(
                    'maxlength' => 10000
                ),
            ))
            ->add('favorite', 'textarea', array(
                'label' => 'favorite',
                'required' => false,
                'attr' => array(
                    'maxlength' => 10000
                ),
            ))
            ->add('article', 'textarea', array(
                'label' => 'article',
                'required' => false,
                'attr' => array(
                    'maxlength' => 10000
                ),
            ))
            ->add('educations', 'collection', array(
                'type' => new EducationType(),
                'options' => array(
                    'data_class' => 'Anar\ProfessorBundle\Entity\Education'
                ),
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'required' => false,
                'by_reference' => false,
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\ProfessorBundle\Entity\Profile',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_professorbundle_profile';
    }
}
