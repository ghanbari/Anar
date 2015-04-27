<?php

namespace Anar\LinkBundle\DataFixtures\ORM;

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
        $link = $this->getReference('AnarLinkBundle');

        $linkIndexMenu = new AppMenu('link.management', $link, $this->getReference('linkIndex'), 'anar_link_backend_index', 'fa fa-globe');
        $linkNewMenu = new AppMenu('link.create', $link, $this->getReference('linkNew'), 'anar_link_backend_new', 'fa fa-link');

        $manager->persist($linkIndexMenu);
        $manager->persist($linkNewMenu);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 22;
    }
}