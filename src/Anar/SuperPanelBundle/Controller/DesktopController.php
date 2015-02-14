<?php

namespace Anar\SuperPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Blog controller.
 *
 */
class DesktopController extends Controller
{
    public function homeAction()
    {
        $blogsCount = $this->getDoctrine()->getRepository('AnarEngineBundle:Blog')->createQueryBuilder('b')
            ->select('count(b.id)')->getQuery()->getSingleScalarResult();
//        $usersCount = $this->getDoctrine()->getRepository('AnarEngineBundle:User')->createQueryBuilder('u')
//            ->select('count(u.id)')->getQuery()->getSingleScalarResult();
        return $this->render(
            'AnarSuperPanelBundle:Desktop:home.html.twig',
            array(
                'usersCount' => 0,
                'blogsCount' => $blogsCount,
                'time' => time(),
                'lastLogin' => 0,
//                'lastLogin' => $this->getUser()->getLastLogin()->getTimestamp(),
            )
        );
    }
}
