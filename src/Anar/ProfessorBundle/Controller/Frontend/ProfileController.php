<?php

namespace Anar\ProfessorBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    public function showAction()
    {
        $blogManager = $this->get('anar_engine.manager.blog');
        $profileRepo = $this->getDoctrine()->getRepository('AnarProfessorBundle:Profile');
        $planRepo = $this->getDoctrine()->getRepository('AnarProfessorBundle:Plan');
        $profile = $profileRepo->findOneByBlog($blogManager->getBlog());
        $plans = $planRepo->findOneByProfile($blogManager->getBlog());

        if (is_null($profile)) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            $blogManager->getTheme('AnarProfessorBundle:Profile:show.html.twig', 'Frontend'),
            array(
                'profile' => $profile,
                'plans' =>$plans
            )
        );
    }
}