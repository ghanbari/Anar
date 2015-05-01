<?php

namespace Anar\MenuBundle\DataFixtures\ORM;

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
        $menu = $this->getReference('AnarMenuBundle');

        $index = new Role('لیست منو ها', 'ANAR_MENU_BACKEND_MENU_INDEX', $menu);
        $new = new Role('افزودن منو', 'ANAR_MENU_BACKEND_MENU_NEW', $menu);
        $create = new Role('افزودن منو', 'ANAR_MENU_BACKEND_MENU_CREATE', $menu, $new);
        $edit = new Role('ویرایش منو', 'ANAR_MENU_BACKEND_MENU_EDIT', $menu);
        $update = new Role('ویرایش منو', 'ANAR_MENU_BACKEND_MENU_UPDATE', $menu, $edit);
        $delete = new Role('حذف منو', 'ANAR_MENU_BACKEND_MENU_DELETE', $menu);

        $manager->persist($index);
        $manager->persist($new);
        $manager->persist($create);
        $manager->persist($edit);
        $manager->persist($update);
        $manager->persist($delete);
        $this->setReference('menuIndex', $index);
        $this->setReference('menuNew', $new);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 51;
    }
}