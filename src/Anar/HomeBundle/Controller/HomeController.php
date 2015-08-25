<?php

namespace Anar\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function showAction()
    {
        $blogManager = $this->get('anar_engine.manager.blog');

        return $this->render($blogManager->getTheme('AnarHomeBundle:Home:show.html.twig'));
    }

    public function latestArticleAction($blogId = null, $limit = 10)
    {
        $blogManager = $this->get('anar_engine.manager.blog');

        if (is_null($blogId) and $blogManager->getBlog()->getParent() and $blogManager->getBlog()->getParent()->getId() != $blogId) {
            $blogId = $blogManager->getRoot()->getId();
        }

        $articleRepo = $this->get('doctrine')->getRepository('AnarContentBundle:Article');
        $now = new \DateTime();
        $articles = $articleRepo->getAllFilterByQuery($blogId, null, true, $now, $now, array('a.createdAt' => 'DESC'), $limit);
        return $this->render($blogManager->getTheme('AnarHomeBundle:Home:latestArticle.html.twig'), array('articles' => $articles));
    }
}