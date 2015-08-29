<?php

namespace Anar\ContentBundle\Controller\Frontend;

use Anar\EngineBundle\Interfaces\ApplicationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller implements ApplicationInterface
{
    public function indexAction($page)
    {
        $blogManager = $this->get('anar_engine.manager.blog');
        $articleRepo = $this->getDoctrine()->getRepository('AnarContentBundle:Article');
        $query = $articleRepo->getAllFullJoinFilterByBlogQuery($blogManager->getBlog()->getId());
        $articles = $this->get('knp_paginator')->paginate($query, $page, 10);

        return $this->render($blogManager->getTheme('AnarContentBundle:Article:index.html.twig', 'Frontend'), array('articles' => $articles));
    }

    public function showAction($slug)
    {
        $blogManager = $this->get('anar_engine.manager.blog');
        $articleRepo = $this->getDoctrine()->getRepository('AnarContentBundle:Article');
        $article = $articleRepo->findOneBy(array('slug' => $slug, 'blog' => $blogManager->getBlog()));
        $article->increaseVisit();
        $this->getDoctrine()->getManager()->flush();

        return $this->render($blogManager->getTheme('AnarContentBundle:Article:show.html.twig', 'Frontend'), array('article' => $article));
    }
}