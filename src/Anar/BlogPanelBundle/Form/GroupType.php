<?php

namespace Anar\BlogPanelBundle\Form;

use Anar\EngineBundle\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupType extends AbstractType
{
    /**
     * @var Blog
     */
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
            ->add('name', 'text', array(
                'label' => 'name',
                'required' => true,
                'attr' => array(
                    'maxlength' => 255,
                ),
            ))
            ->add('default', 'checkbox', array(
                'label' => 'default',
                'required' => false,
                'data' => false,
            ))
            ->add('roles', 'entity', array(
                'class' => 'Anar\EngineBundle\Entity\Role',
                'property' => 'name',
                'label' => 'roles',
                'multiple' => true,
                'required' => false,
                'query_builder' => function ($er) {
                    $qb = $er->createQueryBuilder('r');
                    return $qb->join('r.app', 'a')
                        ->join('a.blogs', 'b')
                        ->where($qb->expr()->eq('b.id', '?1'))
                        ->andWhere($qb->expr()->isNull('r.parent'))
                        ->setParameter(1, $this->blog->getId());
                }
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Anar\EngineBundle\Entity\Group',
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
        return 'anar_blog_panel_group';
    }
}