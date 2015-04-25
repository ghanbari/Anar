<?php

namespace Anar\ContentBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\AppMenu;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAppMenuData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $content = $this->getReference('AnarContentBundle');

        $articleIndexMenu = new AppMenu('article.management', $content, $this->getReference('articleIndex'), 'anar_content_backend_article_index');
        $articleNewMenu = new AppMenu('article.create', $content, $this->getReference('articleNew'), 'anar_content_backend_article_new');
        $categoryIndexMenu = new AppMenu('category.management', $content, $this->getReference('categoryIndex'), 'anar_content_backend_category_index');
        $categoryNewMenu = new AppMenu('category.create', $content, $this->getReference('categoryNew'), 'anar_content_backend_category_new');

        $manager->persist($articleIndexMenu);
        $manager->persist($articleNewMenu);
        $manager->persist($categoryIndexMenu);
        $manager->persist($categoryNewMenu);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 12;
    }
}