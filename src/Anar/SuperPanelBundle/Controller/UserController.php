<?php

namespace Anar\SuperPanelBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\EngineBundle\Entity\User;
use Anar\SuperPanelBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * @return \VBee\SettingBundle\Manager\SettingDoctrineManager
     */
    private function getSetting()
    {
        return $this->get('vbee.manager.setting');
    }

    /**
     * @return \Doctrine\ORM\Query
     */
    private function getUsersQuery()
    {
        $dql = "SELECT u FROM AnarEngineBundle:User u";
        return $this->getDoctrine()->getManager()->createQuery($dql);
    }

    /**
     * Lists all User entities.
     *
     * @return Response
     */
    public function indexAction()
    {
        $paginator = $this->get('knp_paginator');
        $users = $paginator->paginate(
            $this->getUsersQuery(),
            1,
            $this->getSetting()->get('superpanel.item_per_page', 10)
        );
        return $this->render('AnarSuperPanelBundle:User:index.html.twig', array(
            'users' => $users,
            'form' => $this->createSearchForm()->createView(),
            'token' => $this->get('form.csrf_provider')->generateCsrfToken('user_index'),
        ));
    }

    /**
     * Find Users filter by user attribute.
     *
     * @param Request $request
     * @param int $page
     * @return JsonResponse
     */
    public function searchAction(Request $request, $page)
    {
        $form = $this->createSearchForm();
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userRepository = $this->getDoctrine()->getRepository('AnarEngineBundle:User');
            $usersQuery = $userRepository->getUsersQueryFilterBy($form->getData());
            $paginator = $this->get('knp_paginator');
            $itemPerPage = $this->getSetting()->get('superpanel.item_per_page', 10);
            $pagination = $paginator->paginate($usersQuery, $page, $itemPerPage);
            $users = $pagination->getItems();
            return new JsonResponse(array(
                'status' => array(
                    'code' => (count($users) == 0) ? 404 : 200,
                    'message' => (count($users) == 0) ? 'Not Found' : 'OK'
                ),
                'response' => array(
                    'users' => (count($users) != 0) ? array(
                        'username' => $users[0]->getUsername(),
                        'email' => $users[0]->getEmail(),
                        'fname' => $users[0]->getFname(),
                        'lname' => $users[0]->getLname(),
                        'staffCode' => $users[0]->getStaffCode(),
                        'grade' => $users[0]->getGrade()->getName(),
                        'image' => '',
                    ) : array(),
                    'pagination' => array(
                        'count' => $pagination->getTotalItemCount(),
                        'data' => $this->renderView(
                            $pagination->getTemplate(),
                            $this->get('knp_paginator.helper.processor')->render($pagination)
                        )
                    )
                )
            ));
        } else {
            return new JsonResponse(array(
               'status' => array(
                   'code' => 400,
                   'message' => 'Form is invalid'
               ),
                'response' => array(
                    'users' => array()
                )
            ));
        }
    }

    /**
     * Create a form to search users.
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createSearchForm()
    {
        $form = $this->createForm('user_search', array(), array(
            'method' => 'post',
            'action' => $this->generateUrl('anar_super_panel_user_search')
        ));

        $form->add('Search', 'submit');
        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     * @return Response
     */
    public function newAction()
    {
        $user = new User();
        $form = $this->createCreateForm($user);

        return $this->render('AnarSuperPanelBundle:User:new.html.twig', array(
            'user' => $user,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new User entity.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $user = new User();
        $form = $this->createCreateForm($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'User was created! click on link');
            return $this->redirect($this->generateUrl('anar_super_panel_user_index'));
        }

        return $this->render('AnarSuperPanelBundle:User:new.html.twig', array(
            'user' => $user,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $user The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $user)
    {
        $form = $this->createForm('super_panel_user_registraton', $user, array(
            'action' => $this->generateUrl('anar_super_panel_user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @param int $id
     * @return Response
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AnarEngineBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createEditForm($user);

        return $this->render('AnarSuperPanelBundle:User:new.html.twig', array(
            'user'      => $user,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $user
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $user)
    {
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('anar_super_panel_user_update', array('id' => $user->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');

        $user = $em->getRepository('AnarEngineBundle:User')->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createEditForm($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('anar_super_panel_user_edit', array('id' => $id)));
        }

        return $this->render('AnarSuperPanelBundle:User:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Deletes a User entity.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->find('AnarEngineBundle:User', $id);

        if (!$user) {
            $status = array(
                'code' => 404,
                'message' => 'User is not found!'
            );
        }

        if ($this->get('form.csrf_provider')->isCsrfTokenValid('user_index', $request->request->get('token'))) {
            $em->remove($user);
            $em->flush();

            $status = array(
                'code' => 200,
                'message' => 'User is deleted!'
            );
        } else {
            $status = array(
                'code' => 400,
                'message' => 'Token is not valid!'
            );
        }
        return new JsonResponse(array(
            'status' => $status,
            'response' => array()
        ));
    }

    public function checkUsernameAction($username)
    {
        if (!$this->get('fos_user.user_manager')->findUserByUsername($username)) {
            $status = array(
                'code' => 200,
                'message' => 'You can use this username',
            );
        } else {
            $status = array(
                'code' => 0,
                'message' => 'This username is exists!',
            );
        }
        return new JsonResponse(array(
            'status' => $status,
            'response' => array()
        ));
    }
}
