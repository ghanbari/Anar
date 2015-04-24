<?php

namespace Anar\EngineBundle\Doctrine;

use Anar\BlogPanelBundle\Exception\BlogNotSelectedException;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\QueryBuilder;

class BlogManager
{
    /**
     * @var \Anar\EngineBundle\Entity\Blog
     */
    private static $blog = null;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param Registry $doctrine
     * @param RequestStack $requestStack
     */
    public function __construct(Registry $doctrine, RequestStack $requestStack)
    {
        $this->doctrine = $doctrine;
        $this->requestStack = $requestStack;
    }

    /**
     * @return \Anar\EngineBundle\Entity\Blog
     */
    public function getBlog()
    {
        if (is_null(static::$blog)) {
            $request = $this->requestStack->getMasterRequest();

            if (is_null($request)) {
                return;
            }

            if (!$request->attributes->has('blogName')) {
                if (strpos($request->attributes->get('_route'), 'super_panel')) {
                    return null;
                } else {
                    throw new BlogNotSelectedException();
                }
            }

            /** @var QueryBuilder $qb */
            $qb = $this->doctrine->getManager()->createQueryBuilder();
            static::$blog = $qb->select('b')
                ->from('AnarEngineBundle:Blog', 'b')
                ->join('b.theme', 't')
                ->join('b.groups', 'g')
                ->leftJoin('b.parent', 'p')
                ->leftJoin('b.children', 'child')
                ->leftJoin('b.apps', 'apps')
                ->leftJoin('g.users', 'u')
                ->leftJoin('g.roles', 'r')
                ->where($qb->expr()->eq('b.name', '?1'))
                ->setParameter(1, $request->attributes->get('blogName'))
                ->getQuery()->getSingleResult();
        }

        return static::$blog;
    }
}