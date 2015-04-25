<?php

namespace Anar\EngineBundle\Doctrine;

use Anar\BlogPanelBundle\Exception\BlogNotSelectedException;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class BlogManager
{
    /**
     * @var \Anar\EngineBundle\Entity\Blog
     */
    private static $blog = null;

    /**
     * @var array
     */
    private static $blogs = null;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @param Registry $doctrine
     * @param RequestStack $requestStack
     * @param TokenStorage $tokenStorage
     */
    public function __construct(Registry $doctrine, RequestStack $requestStack, $tokenStorage)
    {
        $this->doctrine = $doctrine;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
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

            if (!$request->attributes->has('blogName') and !$request->getSession()->has('blogName')) {
                if (strpos($request->attributes->get('_route'), 'super_panel')) {
                    return null;
                } else {
                    throw new BlogNotSelectedException();
                }
            }

            $blogName = $request->attributes->has('blogName') ?
                $request->attributes->get('blogName') : $request->getSession()->get('blogName');

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
                ->setParameter(1, $blogName)
                ->getQuery()->getSingleResult();
        }

        return static::$blog;
    }

    /**
     * @return array|void
     */
    public function getUserBlogs()
    {
        if (is_null(static::$blogs)) {
            $token = $this->tokenStorage->getToken();

            if (is_null($token) or !$token->getUser()) {
                return;
            }
            static::$blogs = $this->doctrine->getRepository('AnarEngineBundle:User')
                ->getBlogsQueryBuilder($token->getUser()->getId())->getQuery()->getArrayResult();
        }

        return static::$blogs;
    }
}