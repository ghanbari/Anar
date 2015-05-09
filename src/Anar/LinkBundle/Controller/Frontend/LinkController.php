<?php

namespace Anar\LinkBundle\Controller\Frontend;

use Anar\EngineBundle\Interfaces\ApplicationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Link controller.
 *
 */
class LinkController extends Controller implements ApplicationInterface
{
    public function renderAction($positions=array(), $template=null)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $linkRepo = $this->getDoctrine()->getRepository('AnarLinkBundle:Link');
        $links = $linkRepo->getAllFilterByPosition($blog->getId(), $positions);

        $groupedLinks = array();
        foreach ($links as $link) {
            $groupedLinks[$link->getCategory()->getPosition()][$link->getCategory()->getName()][] = $link;
        }

        ksort($groupedLinks, SORT_STRING);

        return $this->render($template?:'AnarLinkBundle:Frontend/Link:footer.html.twig', array('links' => $groupedLinks));
    }
}
