<?php

namespace Anar\BlogPanelBundle\Controller;

use Anar\BlogPanelBundle\Exception\BlogNotSelectedException;
use Anar\EngineBundle\Doctrine\BlogManager;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Component\VarDumper\VarDumper;

class DesktopController
{
    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var CsrfTokenManager
     */
    private $csrfTokenManager;

    /**
     * @var Router
     */
    private $router;

    /**
     * @var BlogManager
     */
    private $blogManager;

    /**
     * @param EngineInterface $templating
     * @param Registry $doctrine
     * @param TokenStorage $tokenStorage
     * @param Session $session
     * @param CsrfTokenManager $csrfTokenManager
     * @param Router $router
     * @param BlogManager $blogManager
     */
    public function __construct(
        EngineInterface $templating,
        Registry $doctrine,
        TokenStorage $tokenStorage,
        Session $session,
        CsrfTokenManager $csrfTokenManager,
        Router $router,
        BlogManager $blogManager
    ) {
        $this->templating = $templating;
        $this->doctrine = $doctrine;
        $this->tokenStorage = $tokenStorage;
        $this->session = $session;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->router = $router;
        $this->blogManager = $blogManager;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request, $blogName=null)
    {
        $blogs = $this->blogManager->getUserBlogs();

        if (is_null($blogName) and !$request->getSession()->has('blogName')) {
            if ($blogs) {
                return new RedirectResponse(
                    $this->router->generate('anar_blog_panel_home_blog', array('blogName' => $blogs[0]['name']))
                );
            } else {
                throw new AccessDeniedException();
            }
        } elseif (!is_null($blogName)) {
            try {
                $blog = $this->blogManager->getBlog();
                $request->getSession()->set('blogName', $blog->getName());
            } catch (BlogNotSelectedException $e) {
                return new RedirectResponse(
                    $this->router->generate('anar_blog_panel_home_blog', array('blogName' => $blogs[0]['name']))
                );
            }
        }

        $linkCount = $this->doctrine->getRepository('AnarLinkBundle:Link')->count($this->blogManager->getBlog()->getId());
        $articleCount = $this->doctrine->getRepository('AnarContentBundle:Article')->count($this->blogManager->getBlog()->getId());
        $expiredArticleCount = $this->doctrine->getRepository('AnarContentBundle:Article')->countExpiredArticle($this->blogManager->getBlog()->getId());

        $token = $this->csrfTokenManager->refreshToken('blogChange');

        // TODO: fix CSRF attack on change blog.
        return $this->templating->renderResponse(
            'AnarBlogPanelBundle:Desktop:index.html.twig',
            array(
                'token' => $token,
                'linkCount' => $linkCount,
                'articleCount' => $articleCount,
                'expiredArticleCount' => $expiredArticleCount,
            )
        );
    }
}
