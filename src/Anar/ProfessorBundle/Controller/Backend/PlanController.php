<?php

namespace Anar\ProfessorBundle\Controller\Backend;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\ProfessorBundle\Entity\Plan;
use Anar\ProfessorBundle\Form\PlanType;

/**
 * Plan controller.
 *
 */
class PlanController extends Controller implements AdminInterface
{

    /**
     * Lists all Plan entities.
     *
     */
    public function indexAction()
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $em = $this->getDoctrine()->getManager();

        $profile = $em->getRepository('AnarProfessorBundle:Profile')->findOneByBlog($blog);
        $dql = "SELECT p FROM AnarProfessorBundle:Plan p WHERE p.profile = :profileId ORDER BY p.dayNumber ASC, p.startTime ASC";
        $plans = $em->createQuery($dql)->setParameter('profileId', $profile->getId())->getResult();

        $token = $this->get('security.csrf.token_manager')->refreshToken('plan_delete');

        return $this->render('AnarProfessorBundle:Backend/Plan:index.html.twig', array(
            'plans' => $plans,
            'token' => $token,
        ));
    }

    /**
     * Displays a form to create a new Plan entity.
     *
     */
    public function newAction()
    {
        $plan = new Plan();
        $form = $this->createCreateForm($plan);

        return $this->render('AnarProfessorBundle:Backend/Plan:new.html.twig', array(
            'entity' => $plan,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new Plan entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $this->get('anar_engine.manager.blog')->getBlog();

        $plan = new Plan();
        $form = $this->createCreateForm($plan);
        $form->handleRequest($request);

        $profile = $em->getRepository('AnarProfessorBundle:Profile')->findOneByBlog($blog);

        if ($form->isValid()) {
            $plan->setProfile($profile);
            $em->persist($plan);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('item.is.created'));
            return $this->redirect($this->generateUrl('anar_professor_backend_plan_index', array('blogName' => $blog->getName())));
        }

        return $this->render('AnarProfessorBundle:Backend/Plan:new.html.twig', array(
            'entity' => $plan,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a form to create a Plan entity.
     *
     * @param Plan $plan The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Plan $plan)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $form = $this->createForm(new PlanType(), $plan, array(
            'action' => $this->generateUrl('anar_professor_backend_plan_create', array('blogName' => $blog->getName())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Plan entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $plan = $em->getRepository('AnarProfessorBundle:Plan')->find($id);
        $blog = $this->get('anar_engine.manager.blog')->getBlog();

        if (!$plan) {
            $this->addFlash('error', $this->get('translator')->trans('plan.is.not.exists'));
            return $this->redirectToRoute('anar_professor_backend_plan_index', array('blogName' => $blog->getName()));
        }

        $form = $this->createEditForm($plan);

        return $this->render('AnarProfessorBundle:Backend/Plan:new.html.twig', array(
            'plan'   => $plan,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
    * Creates a form to edit a Plan entity.
    *
    * @param Plan $plan The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Plan $plan)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $form = $this->createForm(new PlanType(), $plan, array(
            'action' => $this->generateUrl(
                'anar_professor_backend_plan_update',
                array(
                    'id' => $plan->getId(),
                    'blogName' => $blog->getName(),
                )
            ),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Plan entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $plan = $em->getRepository('AnarProfessorBundle:Plan')->find($id);
        $blog = $this->get('anar_engine.manager.blog')->getBlog();

        if (!$plan) {
            $this->addFlash('error', $this->get('translator')->trans('plan.is.not.exists'));
            return $this->redirectToRoute('anar_professor_backend_plan_index', array('blogName' => $blog->getName()));
        }

        $form = $this->createEditForm($plan);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('item.is.updated'));
            return $this->redirect($this->generateUrl('anar_professor_backend_plan_index', array('blogName' => $blog->getName())));
        }

        return $this->render('AnarProfessorBundle:Backend/Plan:new.html.twig', array(
            'plan'   => $plan,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Deletes a Plan entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');
        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('plan_delete', $token)) {
            $status = array(
                'code' => 400,
                'message' => $translator->trans('token.is.invalid')
            );
        } else {
            $em = $this->getDoctrine()->getManager();
            $plan = $em->find('AnarProfessorBundle:Plan', $id);

            if (!$plan) {
                $status = array(
                    'code' => 404,
                    'message' => $translator->trans('not.found')
                );
            } else {
                $em->remove($plan);
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
