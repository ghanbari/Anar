<?php

namespace Anar\LinkBundle\DataFixtures\ORM;

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
        $link = new App('AnarLinkBundle', 'link', 'module');
        $manager->persist($link);
        $manager->flush();
        $this->setReference('AnarLinkBundle', $link);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 20;
    }
}