<?php

namespace Anar\BlogPanelBundle\Menu;

use Anar\EngineBundle\Entity\App;
use Doctrine\ORM\QueryBuilder;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\VarDumper\VarDumper;

class Builder extends ContainerAware
{
    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $manager = $this->container->get('doctrine')->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();

        $qb = $manager->getRepository('AnarEngineBundle:User')->getRolesQueryBuilderFilterByBlog(
            $user->getId(),
            $blog->getId()
        );

        $results = $qb->select('r.id, r.role, IDENTITY(r.app) app')->getQuery()->getArrayResult();

        $appIds = array();
        $userRoles = array();
        $userRolesIds = array();
        foreach ($results as $result) {
            $appIds[] = $result['app'];
            $userRoles[] = $result['role'];
            $userRolesIds[] = $result['id'];
        }

        $qb = $manager->createQueryBuilder()
            ->select(array('am', 'a'))
            ->from('AnarEngineBundle:AppMenu', 'am')
            ->join('am.app', 'a')
            ->join('am.role', 'r');

        if (in_array('ROLE_ADMIN', $userRoles)) {
            $appMenus = $qb->join('a.blogs', 'b')
                ->where($qb->expr()->eq('b.id', ':blogId'))
                ->setParameter('blogId', $blog->getId())
                ->getQuery()->getArrayresult();
        } else {
            $appMenus = $qb->where($qb->expr()->in('am.app', ':appIds'))
                ->andWhere($qb->expr()->in('am.role', ':userRolesIds'))
                ->setParameter('appIds', $appIds)
                ->setParameter('userRolesIds', $userRolesIds)
                ->getQuery()->getArrayresult();
        }

        $menu = $factory->createItem('root');
        $translator = $this->container->get('translator');

        /** @var App $app */
        foreach ($appMenus as $appMenu) {
            if (!$app = $menu->getChild($appMenu['app']['name'])) {
                $app = $menu->addChild(
                    $appMenu['app']['name'],
                    array(
                        /** @Ignore */
                        'label' => $translator->trans($appMenu['app']['title']),
                    )
                );
            }

            $app->addChild(
                $appMenu['name'],
                array(
                    'route' => $appMenu['route'],
                    'extras' => array(
                        'icon' => $appMenu['icon'],
                    ),
                    /** @Ignore */
                    'label' => $translator->trans($appMenu['name'])
                )
            );

        }
        return $menu;
    }
}