<?php

namespace Anar\EngineBundle\EventListener\Doctrine;

use Anar\EngineBundle\Entity\Role;
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
        $superadmin->setCurrentLocale('fa');

        $member = new Group('اعضا', array($user));
        $member->setBlog($blog);
        $member->setDefault(true);
        $member->setCurrentLocale('fa');

        $blogPanel = $em->getRepository('AnarEngineBundle:App')->findOneByName('AnarBlogPanelBundle');
        $blog->addApp($blogPanel);
        $em->persist($superadmin);
        $em->persist($member);
    }
}