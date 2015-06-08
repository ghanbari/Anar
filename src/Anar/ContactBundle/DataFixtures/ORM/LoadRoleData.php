<?php

namespace Anar\ContactBundle\DataFixtures\ORM;

use Anar\EngineBundle\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRoleData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $contact = $this->getReference('AnarContactBundle');

        $readingRole = new Role('تماس با ما', 'ANAR_CONTACT_BACKEND_CONTACT_INDEX', $contact);
        $deleteRole = new Role('حذف تماس با ما', 'ANAR_CONTACT_BACKEND_CONTACT_DELETE', $contact);

        $manager->persist($readingRole);
        $manager->persist($deleteRole);
        $manager->flush();

        $this->setReference('readingRole', $readingRole);
        $this->setReference('deleteRole', $deleteRole);
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 61;
    }
}