<?php

namespace Anar\ProfessorBundle\Controller\Backend;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\ProfessorBundle\Entity\Profile;
use Anar\ProfessorBundle\Form\ProfileType;

/**
 * Profile controller.
 *
 */
class ProfileController extends Controller implements AdminInterface
{
    /**
     * Displays a form to edit an existing Profile entity.
     *
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $profile = $em->getRepository('AnarProfessorBundle:Profile')->findOneByBlog($blog);

        if (!$profile) {
            $profile = new Profile();
            $profile->setBlog($blog);
            $em->persist($profile);
            $em->flush();
        }

        $form = $this->createEditForm($profile);

        return $this->render('AnarProfessorBundle:Backend/Profile:edit.html.twig', array(
            'profile'      => $profile,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to edit a Profile entity.
    *
    * @param Profile $profile The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Profile $profile)
    {
        $form = $this->createForm(new ProfileType(), $profile, array(
            'action' => $this->generateUrl('anar_professor_backend_profile_update'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Profile entity.
     *
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $this->get('anar_engine.manager.blog')->getBlog();

        $profile = $em->getRepository('AnarProfessorBundle:Profile')->findOneByBlog($blog);

        $educations = new ArrayCollection();

        foreach ($profile->getEducations() as $education) {
            $educations->add($education);
        }

        $form = $this->createEditForm($profile);
        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($educations as $education) {
                if (!$profile->getEducations()->contains($education)) {
                    $em->remove($education);
                }
            }

            $em->flush();
            $this->addFlash('info', $this->get('translator')->trans('profile.is.updated'));
            $this->redirectToRoute('anar_professor_backend_profile_index');
        }

        return $this->render('AnarProfessorBundle:Backend/Profile:edit.html.twig', array(
            'profile' => $profile,
            'form'    => $form->createView(),
        ));
    }
}
