<?php

namespace Anar\ContentBundle\Controller;

use Anar\ContentBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $article = new Article();
        $article->setTitle('aaa')->setBlog($blog)->setAbstract('aaaa')->setSlug('aaa');
        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();
        return $this->render('AnarContentBundle:Default:index.html.twig', array('name' => $name));
    }
}
