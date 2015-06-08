<?php

namespace Anar\SlideShowBundle\DataFixtures\ORM;

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
        $slideshow = $this->getReference('AnarSlideShowBundle');

        $slideshowIndex = new AppMenu('image.management', $slideshow, $this->getReference('slideshowIndex'), 'anar_slide_show_backend_index', 'fa fa-picture-o');
        $slideshowNew = new AppMenu('image.create', $slideshow, $this->getReference('slideshowNew'), 'anar_slide_show_backend_new', 'fa fa-cloud-upload');

        $manager->persist($slideshowIndex);
        $manager->persist($slideshowNew);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 42;
    }
}