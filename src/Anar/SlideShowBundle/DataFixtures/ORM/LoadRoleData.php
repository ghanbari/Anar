<?php

namespace Anar\SlideShowBundle\DataFixtures\ORM;

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
        $app = $this->getReference('AnarSlideShowBundle');

        $index = new Role('لیست تصاویر', 'ANAR_SLIDE_SHOW_BACKEND_IMAGE_INDEX', $app);
        $new = new Role('افزودن تصویر', 'ANAR_SLIDE_SHOW_BACKEND_IMAGE_NEW', $app);
        $create = new Role('افزودن تصویر', 'ANAR_SLIDE_SHOW_BACKEND_IMAGE_CREATE', $app, $new);
        $delete = new Role('حذف تصویر', 'ANAR_SLIDE_SHOW_BACKEND_IMAGE_DELETE', $app);

        $manager->persist($index);
        $manager->persist($new);
        $manager->persist($create);
        $manager->persist($delete);
        $this->setReference('slideshowIndex', $index);
        $this->setReference('slideshowNew', $new);

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 41;
    }
}