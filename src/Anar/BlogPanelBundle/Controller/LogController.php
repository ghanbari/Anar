<?php

namespace Anar\BlogPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LogController extends Controller
{
    public function indexAction($page)
    {
        $logRepo = $this->getDoctrine()->getRepository('AnarEngineBundle:Log');
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $query = $logRepo->getFilterByBlogQueryBuilder($blog->getId());
        $logs = $this->get('knp_paginator')->paginate($query, $page, 30);

        return $this->render('AnarBlogPanelBundle:Log:index.html.twig', array('logs' => $logs));
    }
}