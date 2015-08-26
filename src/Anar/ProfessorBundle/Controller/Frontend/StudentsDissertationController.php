<?php

namespace Anar\ProfessorBundle\Controller\Frontend;

use Anar\EngineBundle\Interfaces\ApplicationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StudentsDissertationController extends Controller implements ApplicationInterface
{
    public function showAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $blogManager = $this->get('anar_engine.manager.blog');
        $profileRepo = $this->getDoctrine()->getRepository('AnarProfessorBundle:Profile');
        $profile = $profileRepo->findOneByBlog($blogManager->getBlog());

        if (is_null($profile)) {
            throw $this->createNotFoundException();
        }

        $dql = "SELECT sd FROM AnarProfessorBundle:StudentsDissertation sd WHERE sd.profile = :profileId";
        $query = $em->createQuery($dql)->setParameter('profileId', $profile->getId());
        $studentsDissertation = $this->get('knp_paginator')->paginate($query, $page, 10);

        return $this->render(
            $blogManager->getTheme('AnarProfessorBundle:Dissertation:show.html.twig', 'Frontend'),
            array(
                'profile' => $profile,
                'dissertations' => $studentsDissertation
            )
        );
    }
}