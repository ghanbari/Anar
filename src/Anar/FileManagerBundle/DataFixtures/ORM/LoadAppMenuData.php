<?php

namespace Anar\FileManagerBundle\DataFixtures\ORM;

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
        $app = $this->getReference('AnarFileManagerBundle');
        $role = $this->getReference('fileManagerIndex');

        $menu = new AppMenu('filemanager.management', $app, $role, 'anar_file_manager_homepage', 'fa fa-upload');

        $manager->persist($menu);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 72;
    }
}