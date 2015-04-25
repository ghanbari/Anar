<?php

namespace Anar\ProfessorBundle\DataFixtures\ORM;

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
        $professor = new App('AnarProfessorBundle', 'professor profile', 'component');
        $manager->persist($professor);
        $manager->flush();
        $this->setReference('AnarProfessorBundle', $professor);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 30;
    }
}