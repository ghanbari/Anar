<?php

namespace Anar\HomeBundle\Controller;

use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function showAction()
    {
        $blogManager = $this->get('anar_engine.manager.blog');
        $linkRepo = $this->getDoctrine()->getRepository('AnarLinkBundle:Link');
        /** @var QueryBuilder $qb */
        $qb = $linkRepo->getFilterByBlogQueryBuilder($blogManager->getBlog()->getId());
        $links = $qb->andWhere($qb->expr()->like('l.position', ':position'))
            ->setParameter('position', '%FOOTER%')->getQuery()->getResult();

        foreach ($links as $link) {
            $groupedLinks[$link->getPosition()][] = $link;
        }

        $groupedLinks = array();
        return $this->render(
            $blogManager->getTheme('AnarHomeBundle:Home:show.html.twig'),
            array(
                'links' => $groupedLinks,
            )
        );
    }

    public function latestArticleAction($blogId = null, $limit = 10)
    {
        $blogManager = $this->get('anar_engine.manager.blog');

        if (is_null($blogId) and $blogManager->getBlog()->getParent() and $blogManager->getBlog()->getParent()->getId() != $blogId) {
            $blogId = $blogManager->getRoot()->getId();
        }

        $articleRepo = $this->get('doctrine')->getRepository('AnarContentBundle:Article');
        $articles = $articleRepo->findByBlog($blogId, array('createdAt' => 'DESC'), $limit);
        return $this->render($blogManager->getTheme('AnarHomeBundle:Home:latestArticle.html.twig'), array('articles' => $articles));
    }
}