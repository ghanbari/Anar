<?php

namespace Anar\ContactBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\App;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAppData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $contact = new App('AnarContactBundle', 'contact', 'component');

        $manager->persist($contact);
        $manager->flush();

        $this->setReference('AnarContactBundle', $contact);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 60;
    }
}