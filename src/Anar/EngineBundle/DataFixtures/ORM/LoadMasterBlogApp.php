<?php

namespace Anar\EngineBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadMasterBlogApp extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $masterBlog = $this->getReference('root_blog');

        $masterBlog->addApp($this->getReference('AnarLinkBundle'));
        $masterBlog->addApp($this->getReference('AnarProfessorBundle'));
        $masterBlog->addApp($this->getReference('AnarContentBundle'));
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 150;
    }
}