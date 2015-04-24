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
        $app = $this->getReference('AnarContentBundle');
        $index = new Role('لیست مطالب', 'Anar_Content_Backend_Article_index', $app);
        $new = new Role('افزودن مطلب', 'Anar_Content_Backend_Article_new', $app);
        $create = new Role('افزودن مطلب', 'Anar_Content_Backend_Article_create', $app, $new);
        $edit = new Role('ویرایش مطلب', 'Anar_Content_Backend_Article_edit', $app);
        $update = new Role('ویرایش مطلب', 'Anar_Content_Backend_Article_update', $app, $edit);
        $delete = new Role('حذف مطلب', 'Anar_Content_Backend_Article_delete', $app);

        $manager->persist($index);
        $manager->persist($new);
        $manager->persist($create);
        $manager->persist($edit);
        $manager->persist($update);
        $manager->persist($delete);
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