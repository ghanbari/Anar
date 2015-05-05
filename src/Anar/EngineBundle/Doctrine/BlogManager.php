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
     * @var array
     */
    private static $themes = array();

    /**
     * @var null
     */
    private static $root = null;

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
     * @var \Anar\EngineBundle\Entity\Language
     */
    private $language;

    /**
     * @param Registry $doctrine
     * @param RequestStack $requestStack
     * @param TokenStorage $tokenStorage
     */
    public function __construct(Registry $doctrine, RequestStack $requestStack, $tokenStorage, LanguageManager $languageManager)
    {
        $this->doctrine = $doctrine;
        $this->requestStack = $requestStack;
        $this->tokenStorage = $tokenStorage;
        $this->language = $languageManager->getLanguage();
    }

    public function getRoot()
    {
        if (is_null(static::$root)) {
            $blogRepo = $this->doctrine->getRepository('AnarEngineBundle:Blog');
            static::$root = $blogRepo->findOneByParent(null);
        }
        return static::$root;
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
            static::$blog = $qb->select(array('b', 't', 'g', 'p', 'child', 'apps'))
                ->from('AnarEngineBundle:Blog', 'b')
                ->join('b.theme', 't')
                ->join('b.groups', 'g')
                ->leftJoin('b.parent', 'p')
                ->leftJoin('b.children', 'child')
                ->leftJoin('b.apps', 'apps')
                ->where($qb->expr()->eq('b.name', '?1'))
                ->setParameter(1, $blogName)
                ->getQuery()->getOneOrNullResult();
        }

        if (is_null(static::$blog)) {
            throw new BlogNotSelectedException();
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

    public function getTheme($path)
    {
        if (!isset(static::$themes[$path])) {
            $theme = $this->getBlog()->getTheme();
            $directions = $theme->getDirection();
            $paths = explode(':', $path);

            if (count($paths) != 3) {
                return;
            }

            static::$themes[$path] = array_shift($paths).':';

            if (in_array($this->language->getDirection(), $directions)) {
                static::$themes[$path] .= $theme->getName().'/'.ucfirst($this->language->getDirection()).'/'.array_shift($paths);
            } else {
                static::$themes[$path] .= $theme->getName().'/'. ucfirst(array_pop($theme->getDirection())).'/'.array_shift($paths);
            }

            static::$themes[$path] .= ':'.array_shift($paths);
        }

        return static::$themes[$path];
    }
}