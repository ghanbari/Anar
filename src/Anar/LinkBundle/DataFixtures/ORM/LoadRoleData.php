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

        $index = new Role('لیست لینک ها', 'ANAR_LINK_BACKEND_LINK_INDEX', $app);
        $new = new Role('افزودن لینک', 'ANAR_LINK_BACKEND_LINK_NEW', $app);
        $create = new Role('افزودن لینک', 'ANAR_LINK_BACKEND_LINK_CREATE', $app, $new);
        $edit = new Role('ویرایش لینک', 'ANAR_LINK_BACKEND_LINK_EDIT', $app);
        $update = new Role('ویرایش لینک', 'ANAR_LINK_BACKEND_LINK_UPDATE', $app, $edit);
        $delete = new Role('حذف لینک', 'ANAR_LINK_BACKEND_LINK_DELETE', $app);

        $manager->persist($index);
        $manager->persist($new);
        $manager->persist($create);
        $manager->persist($edit);
        $manager->persist($update);
        $manager->persist($delete);
        $this->setReference('linkIndex', $index);
        $this->setReference('linkNew', $new);

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