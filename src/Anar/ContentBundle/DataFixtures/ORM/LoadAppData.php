<?php

namespace Anar\EngineBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\App;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAppData extends AbstractFixture implements OrderedFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $app = new App('AnarContentBundle', 'content', 'component');
        $manager->persist($app);
        $manager->flush();
        $this->setReference('AnarContentBundle', $app);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 10;
    }
}