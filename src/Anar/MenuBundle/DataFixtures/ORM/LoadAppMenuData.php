<?php

namespace Anar\MenuBundle\DataFixtures\ORM;

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
        $menu = $this->getReference('AnarMenuBundle');

        $menuIndexMenu = new AppMenu('menu.management', $menu, $this->getReference('menuIndex'), 'anar_menu_backend_index', 'fa fa-bookmark');
        $menuNewMenu = new AppMenu('menu.create', $menu, $this->getReference('menuNew'), 'anar_menu_backend_new', 'fa fa-bookmark-o');

        $manager->persist($menuIndexMenu);
        $manager->persist($menuNewMenu);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 52;
    }
}