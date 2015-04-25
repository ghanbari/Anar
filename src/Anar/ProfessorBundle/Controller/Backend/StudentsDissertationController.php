<?php

namespace Anar\ProfessorBundle\Controller\Backend;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\ProfessorBundle\Entity\StudentsDissertation;
use Anar\ProfessorBundle\Form\StudentsDissertationType;

/**
 * StudentsDissertation controller.
 *
 */
class StudentsDissertationController extends Controller implements AdminInterface
{
    /**
     * Lists all StudentsDissertation entities.
     *
     */
    public function indexAction($page)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $em = $this->getDoctrine()->getManager();

        $profile = $em->getRepository('AnarProfessorBundle:Profile')->findOneByBlog($blog);

        $dql = "SELECT sd FROM AnarProfessorBundle:StudentsDissertation sd WHERE sd.profile = :profileId";
        $query = $em->createQuery($dql)->setParameter('profileId', $profile->getId());
        $studentsDissertation = $this->get('knp_paginator')->paginate(
            $query,
            $page,
            $this->get('vbee.manager.setting')->get('blogpanel.item_per_page', 10)
        );

        $token = $this->get('security.csrf.token_manager')->refreshToken('students_dissertation_delete');


        return $this->render('AnarProfessorBundle:Backend/StudentsDissertation:index.html.twig', array(
            'dissertations' => $studentsDissertation,
            'token' => $token,
        ));
    }

    /**
     * Displays a form to create a new StudentsDissertation dissertation.
     *
     */
    public function newAction()
    {
        $studentsDissertation = new StudentsDissertation();
        $form   = $this->createCreateForm($studentsDissertation);

        return $this->render('AnarProfessorBundle:Backend/StudentsDissertation:new.html.twig', array(
            'dissertation' => $studentsDissertation,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new StudentsDissertation dissertation.
     *
     */
    public function createAction(Request $request)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $em = $this->getDoctrine()->getManager();
        $profile = $em->getRepository('AnarProfessorBundle:Profile')->findOneByBlog($blog);
        $dissertation = new StudentsDissertation();
        $form = $this->createCreateForm($dissertation);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $dissertation->setProfile($profile);
            $em->persist($dissertation);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('item.is.created'));
            return $this->redirectToRoute('anar_professor_backend_students_dissertation_index');
        }

        return $this->render('AnarProfessorBundle:Backend/StudentsDissertation:new.html.twig', array(
            'dissertation' => $dissertation,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a form to create a StudentsDissertation dissertation.
     *
     * @param StudentsDissertation $dissertation The dissertation
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(StudentsDissertation $dissertation)
    {
        $form = $this->createForm(new StudentsDissertationType(), $dissertation, array(
            'action' => $this->generateUrl('anar_professor_backend_students_dissertation_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing StudentsDissertation dissertation.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $dissertation = $em->getRepository('AnarProfessorBundle:StudentsDissertation')->find($id);

        if (!$dissertation) {
            $this->addFlash('error', $this->get('translator')->trans('students.dissertation.is.not.exists'));
            return $this->redirectToRoute('anar_professor_backend_students_dissertation_index');
        }

        $form = $this->createEditForm($dissertation);

        return $this->render('AnarProfessorBundle:Backend/StudentsDissertation:new.html.twig', array(
            'dissertation'      => $dissertation,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
    * Creates a form to edit a StudentsDissertation dissertation.
    *
    * @param StudentsDissertation $dissertation The dissertation
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(StudentsDissertation $dissertation)
    {
        $form = $this->createForm(new StudentsDissertationType(), $dissertation, array(
            'action' => $this->generateUrl(
                'anar_professor_backend_students_dissertation_update',
                array('id' => $dissertation->getId())
            ),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing StudentsDissertation dissertation.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $dissertation = $em->getRepository('AnarProfessorBundle:StudentsDissertation')->find($id);

        if (!$dissertation) {
            $this->addFlash('error', $this->get('translator')->trans('students.dissertation.is.not.exists'));
            return $this->redirectToRoute('anar_professor_backend_students_dissertation_index');
        }

        $form = $this->createEditForm($dissertation);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('item.is.updated'));
            return $this->redirectToRoute('anar_professor_backend_students_dissertation_index');
        }

        return $this->render('AnarProfessorBundle:Backend/StudentsDissertation:new.html.twig', array(
            'dissertation' => $dissertation,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Deletes a StudentsDissertation dissertation.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');
        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('students_dissertation_delete', $token)) {
            $status = array(
                'code' => 400,
                'message' => $translator->trans('token.is.invalid')
            );
        } else {
            $em = $this->getDoctrine()->getManager();
            $dissertation = $em->find('AnarProfessorBundle:StudentsDissertation', $id);

            if (!$dissertation) {
                $status = array(
                    'code' => 404,
                    'message' => $translator->trans('not.found')
                );
            } else {
                $em->remove($dissertation);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('item.is.deleted')
                );
            }
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array()
        )))->setStatusCode($status['code']);
    }
}
