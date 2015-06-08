<?php

namespace Anar\ContactBundle\DataFixtures\ORM;

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
        $contact = $this->getReference('AnarContactBundle');

        $indexMenu = new AppMenu('contact.index', $contact, $this->getReference('readingRole'), 'anar_contact_backend_index', 'fa fa-phone');
        $manager->persist($indexMenu);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 62;
    }
}