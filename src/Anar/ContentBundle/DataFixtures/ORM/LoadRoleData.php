<?php

namespace Anar\ContentBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $content = $this->getReference('AnarContentBundle');
        
        $articleIndex = new Role('لیست مطالب', 'ANAR_CONTENT_BACKEND_ARTICLE_INDEX', $content);
        $articleNew = new Role('افزودن مطلب', 'ANAR_CONTENT_BACKEND_ARTICLE_NEW', $content);
        $articleCreate = new Role('افزودن مطلب', 'ANAR_CONTENT_BACKEND_ARTICLE_CREATE', $content, $articleNew);
        $articleEdit = new Role('ویرایش مطلب', 'ANAR_CONTENT_BACKEND_ARTICLE_EDIT', $content);
        $articleUpdate = new Role('ویرایش مطلب', 'ANAR_CONTENT_BACKEND_ARTICLE_UPDATE', $content, $articleEdit);
        $articleDelete = new Role('حذف مطلب', 'ANAR_CONTENT_BACKEND_ARTICLE_DELETE', $content);

        $manager->persist($articleIndex);
        $manager->persist($articleNew);
        $manager->persist($articleCreate);
        $manager->persist($articleEdit);
        $manager->persist($articleUpdate);
        $manager->persist($articleDelete);
        $this->setReference('articleIndex', $articleIndex);
        $this->setReference('articleNew', $articleNew);


        $categoryIndex = new Role('لیست دسته بندی ها', 'Anar_Content_Backend_Category_INDEX', $content);
        $categoryNew = new Role('افزودن دسته بندی', 'ANAR_CONTENT_BACKEND_Category_NEW', $content);
        $categoryCreate = new Role('افزودن دسته بندی', 'ANAR_CONTENT_BACKEND_Category_CREATE', $content, $categoryNew);
        $categoryEdit = new Role('ویرایش دسته بندی', 'ANAR_CONTENT_BACKEND_Category_EDIT', $content);
        $categoryUpdate = new Role('ویرایش دسته بندی', 'ANAR_CONTENT_BACKEND_Category_UPDATE', $content, $categoryEdit);
        $categoryDelete = new Role('حذف دسته بندی', 'ANAR_CONTENT_BACKEND_Category_DELETE', $content);

        $manager->persist($categoryIndex);
        $manager->persist($categoryNew);
        $manager->persist($categoryCreate);
        $manager->persist($categoryEdit);
        $manager->persist($categoryUpdate);
        $manager->persist($categoryDelete);
        $this->setReference('categoryIndex', $categoryIndex);
        $this->setReference('categoryNew', $categoryNew);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 11;
    }
}