<?php

namespace Anar\EngineBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\Grade;
use Doctrine\Common\DataFixtures\Doctrine;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGradeData implements FixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    function load(ObjectManager $manager)
    {
        $first = new Grade('دیپلم');
        $first->setCurrentLocale('fa');
        $manager->persist($first);

        $first = new Grade('لیسانس');
        $first->setCurrentLocale('fa');
        $manager->persist($first);

        $first = new Grade('فوق لیسانس');
        $first->setCurrentLocale('fa');
        $manager->persist($first);

        $first = new Grade('دکترا');
        $first->setCurrentLocale('fa');
        $manager->persist($first);

        $first = new Grade('فوق دکترا');
        $first->setCurrentLocale('fa');
        $manager->persist($first);

        $manager->flush();
    }

}