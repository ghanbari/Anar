<?php

namespace Anar\SuperPanelBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\EngineBundle\Entity\User;
use Anar\SuperPanelBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Email;

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
    public function indexAction($page)
    {
        $paginator = $this->get('knp_paginator');
        $users = $paginator->paginate(
            $this->getUsersQuery(),
            $page,
            $this->getSetting()->get('superpanel.item_per_page', 10)
        );
        return $this->render('AnarSuperPanelBundle:User:index.html.twig', array(
            'users' => $users,
            'form' => $this->createSearchForm()->createView(),
            'token' => $this->get('form.csrf_provider')->generateCsrfToken('user_delete'),
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

        if ($form->isSubmitted()) {
            $userRepository = $this->getDoctrine()->getRepository('AnarEngineBundle:User');
            $usersQuery = $userRepository->getUsersQueryFilterBy($form->getData());
            $users = array();

            foreach ($usersQuery->setMaxResults(300)->getResult() as $user) {
                $users[] = array(
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'fname' => $user->getFname(),
                    'lname' => $user->getLname(),
                    'staffCode' => $user->getStaffCode(),
                    'enabled' => $user->isEnabled(),
                    'image' => '',
                );
            }

            return (new JsonResponse(array(
                'status' => array(
                    'code' => $statusCode = (count($users) == 0) ? 404 : 200,
                    'message' => (count($users) == 0) ? $this->get('translator')->trans('not.found') : 'OK'
                ),
                'response' => array(
                    'users' => $users,
                )
            )))->setStatusCode($statusCode);
        } else {
            return (new JsonResponse(array(
               'status' => array(
                   'code' => 400,
                   'message' => $this->get('translator')->trans('form.is.invalid')
               ),
                'response' => array(
                    'users' => array()
                )
            )))->setStatusCode(400);
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

        $form->add('Search', 'submit', array('label' => 'search'));
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
            $user->setEnabled(true);
            $this->get('fos_user.user_manager')->updateUser($user);

            $request->getSession()->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('user.was.created.successfully')
            );
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

        $form->add('submit', 'submit', array('label' => 'create', 'translation_domain' => 'messages'));

        return $form;
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     * @param int $id
     * @return Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AnarEngineBundle:User')->find($id);

        if (!$user) {
            $request->getSession()->getFlashBag()->add(
                'error',
                $this->get('translator')->trans('user.is.not.exists')
            );
            $this->redirectToRoute('anar_super_panel_user_index');
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

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $userManager = $this->get('fos_user.user_manager');

        $user = $em->getRepository('AnarEngineBundle:User')->find($id);

        if (!$user) {
            $request->getSession()->getFlashBag()->add(
                'error',
                $this->get('translator')->trans('user.is.not.exists')
            );
            $this->redirectToRoute('anar_super_panel_user_index');
        }

        $form = $this->createEditForm($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $userManager->updateUser($user);

            $request->getSession()->getFlashBag()->add(
                'info',
                $this->get('translator')->trans('user.was.edited.successfully')
            );
            return $this->redirect($this->generateUrl('anar_super_panel_user_index', array('id' => $id)));
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
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('user_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $user = $em->find('AnarEngineBundle:User', $id);

            if (!$user) {
                $status = array(
                    'code' => 404,
                    'message' => $translator->trans('user.is.not.exists')
                );
            } else {
                $em->remove($user);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('user.was.deleted')
                );
            }
        } else {
            $status = array(
                'code' => 400,
                'message' => $translator->trans('token.is.invalid')
            );
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array()
        )))->setStatusCode($status['code']);
    }

    /**
     * check whether username is exists.
     *
     * @param $username
     * @return JsonResponse
     */
    public function checkUsernameAction($username)
    {
        $translator = $this->get('translator');
        if ($this->get('fos_user.user_manager')->findUserByUsername($username)) {
            $status = array(
                'code' => 403,
                'message' => $translator->trans('name.is.exists'),
            );
        } else {
            if (is_string($username) and preg_match('/^[a-z0-9_]{2,255}$/i', $username)) {
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('you.can.use.this.username'),
                );
            } else {
                $status = array(
                    'code' => 400,
                    'message' => $translator->trans('username.not.have.valid.character'),
                );
            }
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array()
        )))->setStatusCode($status['code']);
    }

    /**
     * check whether username is exists.
     *
     * @param @email
     * @return JsonResponse
     */
    public function isEmailValidAction(Request $request)
    {
        $translator = $this->get('translator');
        $emailConstraint = new Email();
        $email = $request->request->get('email');
        $errors = $this->get('validator')->validateValue($email, $emailConstraint);
        if ($this->get('fos_user.user_manager')->findUserByEmail($email)) {
            $status = array(
                'code' => 403,
                'message' => $translator->trans('email.is.exists'),
            );
        } else {
            if (is_string($email) and count($errors) == 0) {
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('you.can.use.this.email'),
                );
            } else {
                $status = array(
                    'code' => 400,
                    'message' => $translator->trans('email.is.not.valid'),
                );
            }
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array()
        )))->setStatusCode($status['code']);
    }

    public function permissionAction($id)
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();
        $dql = "SELECT IDENTITY(g.blog) From AnarEngineBundle:Group g JOIN g.roles r JOIN g.users u WITH u.id = :user WHERE r.role = 'ROLE_ADMIN' ";
        $userBlogs = $manager->createQuery($dql)->setParameter('user', $id)->getResult();
        $userBlogIds = array();

        foreach ($userBlogs as $userBlog) {
            $userBlogIds[] = (int) $userBlog[1];
        }

        $tree = $doctrine->getRepository('AnarEngineBundle:Blog')->getTreeForJstree(null, null, null, null, $userBlogIds);
        return (new JsonResponse(array(
            'status' => array(
                'code' => 200,
                'message' => 'OK',
            ),
            'response' => array(
                'tree' => $tree,
                'token' => (string) $this->get('security.csrf.token_manager')->refreshToken('user_permission'),
            ),
        )))->setStatusCode(200);
    }

    public function permissionUpdateAction(Request $request, $id)
    {
        $translator = $this->get('translator');
        $token   = $request->request->get('token', null);
        $blogIds = (array) $request->request->get('blogIds', array());

        if (!$this->isCsrfTokenValid('user_permission', $token)) {
            $status = array(
                'code' => 400,
                $translator->trans('token.is.invalid'),
            );
        } else {
            $manager = $this->getDoctrine()->getManager();

            $user = $manager->createQuery('SELECT u FROM AnarEngineBundle:User u LEFT JOIN u.groups g WHERE u.id = :id')
                ->setParameter('id', $id)->getOneOrNullResult();

            $dql = "SELECT g FROM AnarEngineBundle:Group g JOIN g.blog b JOIN g.roles r WHERE r.role = 'ROLE_ADMIN' AND b.id IN(:blogIds)";
            $userNewAdminGroups = $manager->createQuery($dql)->setParameter('blogIds', $blogIds)->getResult();

            $dql = "SELECT g From AnarEngineBundle:Group g JOIN g.roles r JOIN g.users u WITH u.id = :user WHERE r.role = 'ROLE_ADMIN' ";
            $userOldAdminGroups = $manager->createQuery($dql)->setParameter('user', $id)->getResult();


            if (!$user) {
                $status = array(
                    'code' => 400,
                    'message' => $translator->trans('user.is.not.exists'),
                );
            } else {
                $status = array(
                    'code' => 200,
                    'message' => 'OK'
                );
            }

            foreach ($userOldAdminGroups as $group) {
                $user->removeGroup($group);
            }

            foreach ($userNewAdminGroups as $group) {
                $user->addGroup($group);
            }

            $manager->flush();
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array()
        )))->setStatusCode($status['code']);
    }

    public function statusChangeAction(Request $request)
    {
        $id = $request->request->get('id');
        $token = $request->request->get('token');
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('user_delete', $token)) {
            $user = $this->getDoctrine()->getRepository('AnarEngineBundle:User')->find($id);

            if (!$user) {
                $status = array(
                    'code' => 404,
                    'message' => $translator->trans('user.is.not.exists'),
                );
            } else {
                $user->setEnabled(!$user->isEnabled());
                $this->getDoctrine()->getManager()->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('user.is.'. $user->isEnabled() ? 'enabled' : 'disabled'),
                );
            }
        } else {
            $status = array(
                'code' => 400,
                'message' => $translator->trans('token.is.invalid'),
            );
        }

        return new JsonResponse(array(
            'status' => $status,
            'response' => array('enabled' => $user->isEnabled())
        ), $status['code']);
    }
}
