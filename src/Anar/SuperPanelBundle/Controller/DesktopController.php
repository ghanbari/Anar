<?php

namespace Anar\SuperPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Blog controller.
 *
 */
class DesktopController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $blogsCount = $this->getDoctrine()->getRepository('AnarEngineBundle:Blog')->createQueryBuilder('b')
            ->select('count(b.id)')->getQuery()->getSingleScalarResult();
        $usersCount = $this->getDoctrine()->getRepository('AnarEngineBundle:User')->createQueryBuilder('u')
            ->select('count(u.id)')->getQuery()->getSingleScalarResult();
        return $this->render(
            'AnarSuperPanelBundle:Desktop:home.html.twig',
            array(
                'usersCount' => $usersCount,
                'blogsCount' => $blogsCount,
                'time' => time(),
                'lastLogin' => $this->getUser()->getLastLogin()->getTimestamp(),
            )
        );
    }

    /**
     * @return JsonResponse
     */
    public function statusAction()
    {
        $blogsCount = $this->getDoctrine()->getRepository('AnarEngineBundle:Blog')->createQueryBuilder('b')
            ->select('count(b.id)')->getQuery()->getSingleScalarResult();
        $usersCount = $this->getDoctrine()->getRepository('AnarEngineBundle:User')->createQueryBuilder('u')
            ->select('count(u.id)')->getQuery()->getSingleScalarResult();

        return new JsonResponse(array(
            'status' => array(
                'code' => 200,
                'message' => 'OK'
            ),
            'response' => array(
                'blogsCount' => $blogsCount,
                'usersCount' => $usersCount,
            ),
        ));
    }
}
