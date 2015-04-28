<?php

namespace Anar\ProfessorBundle\DataFixtures\ORM;

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
        $professor = $this->getReference('AnarProfessorBundle');

        $profileIndexMenu = new AppMenu('profile.management', $professor, $this->getReference('profileIndex'), 'anar_professor_backend_profile_index', 'fa fa-user');
        $planIndexMenu = new AppMenu('plan.management', $professor, $this->getReference('planIndex'), 'anar_professor_backend_plan_index', 'fa fa-columns');
        $planNewMenu = new AppMenu('plan.create', $professor, $this->getReference('planNew'), 'anar_professor_backend_plan_new', 'fa fa-calendar');
        $dissertationIndexMenu = new AppMenu('dissertation.management', $professor, $this->getReference('dissertationIndex'), 'anar_professor_backend_students_dissertation_index', 'fa fa-book');
        $dissertationNewMenu = new AppMenu('dissertation.create', $professor, $this->getReference('dissertationNew'), 'anar_professor_backend_students_dissertation_new', 'fa fa-foursquare');

        $manager->persist($profileIndexMenu);
        $manager->persist($planIndexMenu);
        $manager->persist($planNewMenu);
        $manager->persist($dissertationIndexMenu);
        $manager->persist($dissertationNewMenu);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 32;
    }
}