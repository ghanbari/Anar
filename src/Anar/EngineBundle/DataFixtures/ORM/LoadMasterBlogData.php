<?php

namespace Anar\EngineBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\Blog;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadMasterBlogData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{

    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $blog = new Blog();
        $name = $this->container->hasParameter('master_blog') ? $this->container->getParameter('master_blog') : 'main';
        $title = $this->container->hasParameter('title') ? $this->container->getParameter('title') : 'Anar Notification System';
        $blog->setName($name)->setTitle($title)->setCurrentLocale($this->container->getParameter('locale'));
        $blog->setTheme($this->getReference('theme.public'));
        $manager->persist($blog);
        $manager->flush();

        $this->addReference('root_blog', $blog);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    }
}