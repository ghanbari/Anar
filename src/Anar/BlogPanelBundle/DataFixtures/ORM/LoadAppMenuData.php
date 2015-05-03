<?php

namespace Anar\BlogPanelBundle\DataFixtures\ORM;

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
        $blogPanel = $this->getReference('AnarBlogPanelBundle');
        $adminRole = $manager->getRepository('AnarEngineBundle:Role')->findOneByRole('ROLE_ADMIN');

        $groupIndexMenu = new AppMenu('group.management', $blogPanel, $adminRole, 'anar_blog_panel_group_index', 'fa fa-group');
        $groupNewMenu = new AppMenu('group.create', $blogPanel, $adminRole, 'anar_blog_panel_group_new', 'fa fa-group');
        $groupUsersIndexMenu= new AppMenu('group.users.management', $blogPanel, $adminRole, 'anar_blog_panel_group_user', 'fa fa-group');
        $logMenu = new AppMenu('logs', $blogPanel, $adminRole, 'anar_blog_panel_log', 'fa fa-exclamation-triangle');

        $manager->persist($groupIndexMenu);
        $manager->persist($groupNewMenu);
        $manager->persist($groupUsersIndexMenu);
        $manager->persist($logMenu);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}