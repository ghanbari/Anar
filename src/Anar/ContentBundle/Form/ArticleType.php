<?php

namespace Anar\ContentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'title',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                )
            ))
            ->add('slug', 'text', array(
                'label' => 'slug',
                'required' => true,
                'attr' => array(
//                    'pattern' => '[a-zA-Z0-9_]{4-255}'
                )
            ))
            ->add('abstract', 'textarea', array(
                'label' => 'abstract',
                'required' => true,
            ))
            ->add('article', 'textarea', array(
                'label' => 'article',
                'required' => false,
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'enabled',
                'required' => false,
                'data' => true,
            ))
            ->add('publicationStartDate', 'date', array(
                'label' => 'publication.start.from.date',
                'required' => false,
                'format' => 'yyyy/MM/dd',
                'widget' => 'single_text',
            ))
            ->add('publicationEndDate', 'date', array(
                'label' => 'publication.end.in.date',
                'required' => false,
                'format' => 'yyyy/MM/dd',
                'widget' => 'single_text',
            ))
            ->add('imageFile', 'vich_file', array(
                'required' => false,
            ))
            ->add('category', 'entity', array(
                'label' => 'category',
                'required' => false,
                'placeholder' => 'placeholder',
                'class' => 'Anar\ContentBundle\Entity\Category',
                'property' => 'title',
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\ContentBundle\Entity\Article',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_contentbundle_article';
    }
}
