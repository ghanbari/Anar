<?php

namespace Anar\ProfessorBundle\DataFixtures\ORM;

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
        $professor = $this->getReference('AnarProfessorBundle');

        $profileIndex = new Role('مدیریت پروفایل', 'ANAR_PROFESSOR_BACKEND_PROFILE_INDEX', $professor);
        $profileEdit = new Role('مدیریت پروفایل', 'ANAR_PROFESSOR_BACKEND_PROFILE_EDIT', $professor, $profileIndex);
        $profileUpdate = new Role('مدیریت پروفایل', 'ANAR_PROFESSOR_BACKEND_PROFILE_UPDATE', $professor, $profileIndex);
        $manager->persist($profileIndex);
        $manager->persist($profileEdit);
        $manager->persist($profileUpdate);
        $this->setReference('profileIndex', $profileIndex);


        $planIndex = new Role('لیست برنامه هفتگی', 'ANAR_PROFESSOR_BACKEND_PLAN_INDEX', $professor);
        $planNew = new Role('افزودن برنامه هفتگی', 'ANAR_PROFESSOR_BACKEND_PLAN_NEW', $professor);
        $planCreate = new Role('افزودن برنامه هفتگی', 'ANAR_PROFESSOR_BACKEND_PLAN_CREATE', $professor, $planNew);
        $planEdit = new Role('ویرایش برنامه هفتگی', 'ANAR_PROFESSOR_BACKEND_PLAN_EDIT', $professor);
        $planUpdate = new Role('ویرایش برنامه هفتگی', 'ANAR_PROFESSOR_BACKEND_PLAN_UPDATE', $professor, $planEdit);
        $planDelete = new Role('حذف برنامه هفتگی', 'ANAR_PROFESSOR_BACKEND_PLAN_DELETE', $professor);

        $manager->persist($planIndex);
        $manager->persist($planNew);
        $manager->persist($planCreate);
        $manager->persist($planEdit);
        $manager->persist($planUpdate);
        $manager->persist($planDelete);
        $this->setReference('planIndex', $planIndex);
        $this->setReference('planNew', $planNew);


        $dissertationIndex = new Role('لیست پایان نامه', 'ANAR_PROFESSOR_BACKEND_DISSERTATION_INDEX', $professor);
        $dissertationNew = new Role('افزودن پایان نامه', 'ANAR_PROFESSOR_BACKEND_DISSERTATION_NEW', $professor);
        $dissertationCreate = new Role('افزودن پایان نامه', 'ANAR_PROFESSOR_BACKEND_DISSERTATION_CREATE', $professor, $dissertationNew);
        $dissertationEdit = new Role('ویرایش پایان نامه', 'ANAR_PROFESSOR_BACKEND_DISSERTATION_EDIT', $professor);
        $dissertationUpdate = new Role('ویرایش پایان نامه', 'ANAR_PROFESSOR_BACKEND_DISSERTATION_UPDATE', $professor, $dissertationEdit);
        $dissertationDelete = new Role('حذف پایان نامه', 'ANAR_PROFESSOR_BACKEND_DISSERTATION_DELETE', $professor);

        $manager->persist($dissertationIndex);
        $manager->persist($dissertationNew);
        $manager->persist($dissertationCreate);
        $manager->persist($dissertationEdit);
        $manager->persist($dissertationUpdate);
        $manager->persist($dissertationDelete);
        $this->setReference('dissertationIndex', $dissertationIndex);
        $this->setReference('dissertationNew', $dissertationNew);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 31;
    }
}