<?php

namespace Anar\ProfessorBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileController extends Controller
{
    public function showAction()
    {
        $blogManager = $this->get('anar_engine.manager.blog');
        $profileRepo = $this->getDoctrine()->getRepository('AnarProfessorBundle:Profile');
        $profile = $profileRepo->findOneByBlog($blogManager->getBlog());

        if (is_null($profile)) {
            throw $this->createNotFoundException();
        }

        $planRepo = $this->getDoctrine()->getRepository('AnarProfessorBundle:Plan');
        $plans = $planRepo->findByProfile($profile->getId());
        $groupedPlans = array();
        foreach ($plans as $plan) {
            $groupedPlans[$plan->getDayNumber()][] = $plan;
        }

        ksort($groupedPlans);

        return $this->render(
            $blogManager->getTheme('AnarProfessorBundle:Profile:show.html.twig', 'Frontend'),
            array(
                'profile' => $profile,
                'plans' => $groupedPlans
            )
        );
    }
}