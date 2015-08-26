<?php

namespace Anar\ContentBundle\Controller\Frontend;

use Anar\EngineBundle\Interfaces\ApplicationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller implements ApplicationInterface
{
    public function indexAction($slug, $page)
    {
        $blogManager = $this->get('anar_engine.manager.blog');
        $articleRepo = $this->getDoctrine()->getRepository('AnarContentBundle:Article');
        $query = $articleRepo->getAllFullJoinFilterByBlogAndCategoryQuery($blogManager->getBlog()->getId(), $slug);
        $articles = $this->get('knp_paginator')->paginate($query, $page, 10);

        return $this->render($blogManager->getTheme('AnarContentBundle:Article:index.html.twig', 'Frontend'), array('articles' => $articles));
    }
}