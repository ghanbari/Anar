<?php

namespace Anar\BlogPanelBundle\Controller;

use Anar\BlogPanelBundle\Exception\BlogNotSelectedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DesktopController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction(Request $request, $blogName=null)
    {
        #Set fallback for content in panels
        $this->get('stof_doctrine_extensions.listener.translatable')->setTranslationFallback(true);

        $doctrine = $this->getDoctrine();
        $blogManager = $this->get('anar_engine.manager.blog');
        $blogs = $blogManager->getUserBlogs();

        if (is_null($blogName) and !$request->getSession()->has('blogName')) {
            if ($blogs) {
                return new RedirectResponse(
                    $this->generateUrl('anar_blog_panel_home_blog', array('blogName' => $blogs[0]['name']))
                );
            } else {
                throw new AccessDeniedException();
            }
        } elseif (!is_null($blogName)) {
            try {
                $blog = $blogManager->getBlog();
                $request->getSession()->set('blogName', $blog->getName());
            } catch (BlogNotSelectedException $e) {
                return new RedirectResponse(
                    $this->generateUrl('anar_blog_panel_home_blog', array('blogName' => $blogs[0]['name']))
                );
            }
        }

        $linkCount = $doctrine->getRepository('AnarLinkBundle:Link')->count($blogManager->getBlog()->getId());
        $articleCount = $doctrine->getRepository('AnarContentBundle:Article')->count($blogManager->getBlog()->getId());
        $expiredArticleCount = $doctrine->getRepository('AnarContentBundle:Article')->countExpiredArticle($blogManager->getBlog()->getId());

        $token = $this->get('security.csrf.token_manager')->refreshToken('blogChange');

        // TODO: fix CSRF attack on change blog.
        return $this->render(
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
