<?php

namespace Anar\LinkBundle\DataFixtures\ORM;

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
        $app = $this->getReference('AnarLinkBundle');
        $index = new Role('لیست لینک ها', 'Anar_Link_Backend_Link_index', $app);
        $new = new Role('افزودن لینک', 'Anar_Link_Backend_Link_new', $app);
        $create = new Role('افزودن لینک', 'Anar_Link_Backend_Link_create', $app, $new);
        $edit = new Role('ویرایش لینک', 'Anar_Link_Backend_Link_edit', $app);
        $update = new Role('ویرایش لینک', 'Anar_Link_Backend_Link_update', $app, $edit);
        $delete = new Role('حذف لینک', 'Anar_Link_Backend_Link_delete', $app);

        $manager->persist($index);
        $manager->persist($new);
        $manager->persist($create);
        $manager->persist($edit);
        $manager->persist($update);
        $manager->persist($delete);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 21;
    }
}