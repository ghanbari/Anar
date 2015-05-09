<?php

namespace Anar\LinkBundle\DataFixtures\ORM;

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
        $app = $this->getReference('AnarLinkBundle');

        $linkIndex = new Role('لیست لینک ها', 'ANAR_LINK_BACKEND_LINK_INDEX', $app);
        $linkNew = new Role('افزودن لینک', 'ANAR_LINK_BACKEND_LINK_NEW', $app);
        $linkCreate = new Role('افزودن لینک', 'ANAR_LINK_BACKEND_LINK_CREATE', $app, $linkNew);
        $linkEdit = new Role('ویرایش لینک', 'ANAR_LINK_BACKEND_LINK_EDIT', $app);
        $linkUpdate = new Role('ویرایش لینک', 'ANAR_LINK_BACKEND_LINK_UPDATE', $app, $linkEdit);
        $linkDelete = new Role('حذف لینک', 'ANAR_LINK_BACKEND_LINK_DELETE', $app);

        $categoryIndex = new Role('لیست لینک ها', 'ANAR_CATEGORY_BACKEND_CATEGORY_INDEX', $app);
        $categoryNew = new Role('افزودن لینک', 'ANAR_CATEGORY_BACKEND_CATEGORY_NEW', $app);
        $categoryCreate = new Role('افزودن لینک', 'ANAR_CATEGORY_BACKEND_CATEGORY_CREATE', $app, $categoryNew);
        $categoryEdit = new Role('ویرایش لینک', 'ANAR_CATEGORY_BACKEND_CATEGORY_EDIT', $app);
        $categoryUpdate = new Role('ویرایش لینک', 'ANAR_CATEGORY_BACKEND_CATEGORY_UPDATE', $app, $categoryEdit);
        $categoryDelete = new Role('حذف لینک', 'ANAR_CATEGORY_BACKEND_CATEGORY_DELETE', $app);

        $manager->persist($linkIndex);
        $manager->persist($linkNew);
        $manager->persist($linkCreate);
        $manager->persist($linkEdit);
        $manager->persist($linkUpdate);
        $manager->persist($linkDelete);
        $manager->persist($categoryIndex);
        $manager->persist($categoryNew);
        $manager->persist($categoryCreate);
        $manager->persist($categoryEdit);
        $manager->persist($categoryUpdate);
        $manager->persist($categoryDelete);
        $this->setReference('linkIndex', $linkIndex);
        $this->setReference('linkNew', $linkNew);
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
        return 21;
    }
}