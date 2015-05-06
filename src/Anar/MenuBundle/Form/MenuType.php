<?php

namespace Anar\MenuBundle\Form;

use Anar\EngineBundle\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MenuType extends AbstractType
{
    /**
     * @var Blog
     */
    private $blog;

    public function __construct(Blog $blog)
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
            ->add('name', 'text', array(
                'label' => 'name',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('url', 'url', array(
                'label' => 'website',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('parent', 'entity', array(
                'label' => 'parent',
                'required' => true,
                'class' => 'Anar\MenuBundle\Entity\Menu',
                'property' => 'name',
                'query_builder' => function ($er) {
                    $qb = $er->createQueryBuilder('m');

                    return $qb->where($qb->expr()->eq('m.blog', '?1'))
                        ->setParameter(1, $this->blog->getId());
                }
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\MenuBundle\Entity\Menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'anar_menubundle_menu';
    }
}
