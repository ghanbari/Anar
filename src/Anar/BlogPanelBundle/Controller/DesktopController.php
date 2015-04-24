<?php

namespace Anar\BlogPanelBundle\Controller;

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
    public function homeAction($blogName=null)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $blogs = $this->doctrine->getRepository('AnarEngineBundle:User')
            ->getBlogsQueryBuilder($user->getId())->select('b.id, b.title, b.name')->getQuery()->getResult();

        if (is_null($blogName)) {
            if ($blogs) {
                return new RedirectResponse(
                    $this->router->generate('anar_blog_panel_home_blog', array('blogName' => $blogs[0]['name']))
                );
            } else {
                throw new AccessDeniedException();
            }
        }

        $blog = $this->blogManager->getBlog();
        $token = $this->csrfTokenManager->refreshToken('blogChange');

        return $this->templating->renderResponse(
            'AnarBlogPanelBundle:Desktop:index.html.twig',
            array('blog' => $blog, 'blogs' => $blogs, 'token' => $token,)
        );
    }
}
