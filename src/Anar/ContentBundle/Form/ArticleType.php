<?php

namespace Anar\ContentBundle\Form;

use Anar\EngineBundle\Doctrine\BlogManager;
use Anar\EngineBundle\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;

class ArticleType extends AbstractType
{

    /**
     * @var Blog
     */
    private $blog;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @param BlogManager $blogManager
     * @param Registry $doctrine
     */
    public function __construct(BlogManager $blogManager, Registry $doctrine)
    {
        $this->blog = $blogManager->getBlog();
        $this->doctrine = $doctrine;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $categoryRepo = $this->doctrine->getRepository('AnarContentBundle:Category');
        $categories = $categoryRepo->getAllFilterByBlog($this->blog->getId());
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
                    'pattern' => '[a-zA-Z0-9_]{4,255}',
                    'placeholder' => 'word.between.4_255'
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
            ->add('imageFile', 'file', array(
                'required' => false,
                'label' => 'image',
                'constraints' => new Image(),
            ))
            ->add('attach', 'text', array(
                'required' => false,
                'label' => 'attachment',
            ))
            ->add('category', 'entity', array(
                'label' => 'category',
                'required' => false,
                'placeholder' => 'placeholder',
                'class' => 'Anar\ContentBundle\Entity\Category',
                'property' => 'title',
                'choices' => $categories,
                'query_builder' => function ($er) {
                    $qb = $er->createQueryBuilder('c');

                    return $qb->where($qb->expr()->eq('c.blog', '?1'))
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
            'data_class' => 'Anar\ContentBundle\Entity\Article',
            'translation_domain' => 'forms',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'article';
    }
}
