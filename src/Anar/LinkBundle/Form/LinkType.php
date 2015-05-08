<?php

namespace Anar\LinkBundle\Form;

use Anar\LinkBundle\Entity\Link;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType
{

    private $blog;

    /**
     * @param $blog
     */
    public function __construct($blog)
    {
        $this->blog = $blog;
    }

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
            ->add('category', 'entity', array(
                'class' => 'Anar\LinkBundle\Entity\Category',
                'property' => 'name',
                'label' => 'category',
                'required' => true,
                'query_builder' => function ($er) {
                    return $er->createQueryBuilder('c')
                        ->where('c.blog = ?1')
                        ->setParameter(1, $this->blog->getId());
                }
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
