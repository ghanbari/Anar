<?php

namespace Anar\EngineBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\App;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAppData implements FixtureInterface
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

        $this->addReference('content_application', $app);
    }
}