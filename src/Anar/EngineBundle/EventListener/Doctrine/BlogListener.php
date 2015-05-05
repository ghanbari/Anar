<?php

namespace Anar\EngineBundle\EventListener\Doctrine;

use Anar\EngineBundle\Entity\Role;
use Anar\MenuBundle\Entity\Menu;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Anar\EngineBundle\Entity\Group;
use Anar\EngineBundle\Entity\Blog;

class BlogListener
{
    public function prePersist(Blog $blog, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        $roleRepo = $em->getRepository('AnarEngineBundle:Role');

        $admin = $roleRepo->findOneByRole('ROLE_ADMIN');
        $user = $roleRepo->findOneByRole('ROLE_USER');

        $superadmin = new Group('مدیرکل', array($admin));
        $superadmin->setBlog($blog);
        $superadmin->setLocked(true);
        $superadmin->setCurrentLocale('fa');

        $member = new Group('اعضا', array($user));
        $member->setBlog($blog);
        $member->setDefault(true);
        $member->setCurrentLocale('fa');

        $blogMenu = new Menu();
        $blogMenu->setBlog($blog);
        $blogMenu->setUrl('');
        $blogMenu->setName($blog->getName());

        $blogPanel = $em->getRepository('AnarEngineBundle:App')->findOneByName('AnarBlogPanelBundle');
        $blog->addApp($blogPanel);
        $em->persist($blogMenu);
        $em->persist($superadmin);
        $em->persist($member);
    }
}