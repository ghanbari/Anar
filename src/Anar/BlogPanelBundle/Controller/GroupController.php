<?php

namespace Anar\BlogPanelBundle\Controller;

use Anar\BlogPanelBundle\Form\GroupType;
use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Anar\EngineBundle\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends Controller implements AdminInterface
{
    public function indexAction()
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $groupRepo = $this->getDoctrine()->getRepository('AnarEngineBundle:Group');
        $groups = $groupRepo->getAllFilterByBlog($blog->getId());

        $token = $this->get('security.csrf.token_manager')->refreshToken('group_delete');

        return $this->render(
          'AnarBlogPanelBundle:Group:index.html.twig',
            array(
                'groups' => $groups,
                'token' => $token,
            )
        );
    }

    public function newAction()
    {
        $group = new Group();
        $form = $this->createCreateForm($group);

        return $this->render(
            'AnarBlogPanelBundle:Group:new.html.twig',
            array(
                'group' => $group,
                'form' => $form->createView(),
                'action' => 'create',
            )
        );
    }

    private function createCreateForm($group)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $form = $this->createForm(new GroupType($blog), $group, array(
            'action' => $this->generateUrl('anar_blog_panel_group_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    public function createAction(Request $request)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $group = new Group();
        $group->setBlog($blog);
        $form = $this->createCreateForm($group);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $roleRepo = $em->getRepository('AnarEngineBundle:Role');
            if ($group->isDefault()) {
                $groupRepo = $em->getRepository('AnarEngineBundle:Group');
                $groupRepo->resetDefaultForBlog($blog->getId());
            }
            $group->setRoles($roleRepo->getRolesHierachy($group->getRoles()));
            $em->persist($group);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('group.was.created.successfully'));
            return $this->redirectToRoute('anar_blog_panel_group_index');
        }

        return $this->render(
            'AnarBlogPanelBundle:Group:new.html.twig',
            array(
                'group' => $group,
                'form' => $form->createView(),
                'action' => 'create',
            )
        );
    }

    /**
     * Displays a form to edit an existing Group entity.
     *
     * @param $groupId
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($groupId)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $group = $em->getRepository('AnarEngineBundle:Group')->find($groupId);

        if (!$group or $group->isLocked()) {
            $this->addFlash('error', $this->get('translator')->trans('group.is.not.exists'));
            return $this->redirectToRoute('anar_blog_panel_group_index');
        }

        if (!$blog->getGroups()->contains($group)) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createEditForm($group);

        return $this->render('AnarBlogPanelBundle:Group:new.html.twig', array(
            'group'  => $group,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Creates a form to edit a Group entity.
     *
     * @param Group $group The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Group $group)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $form = $this->createForm(new GroupType($blog), $group, array(
            'action' => $this->generateUrl('anar_blog_panel_group_update', array('groupId' => $group->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Group entity.
     *
     */
    public function updateAction(Request $request, $groupId)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $group = $em->getRepository('AnarEngineBundle:Group')->find($groupId);

        if (!$group or $group->isLocked()) {
            $this->addFlash('error', $this->get('translator')->trans('group.is.not.exists'));
            return $this->redirectToRoute('anar_blog_panel_group_index');
        }

        if (!$blog->getGroups()->contains($group)) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createEditForm($group);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $roleRepo = $em->getRepository('AnarEngineBundle:Role');
            $group->setRoles($roleRepo->getRolesHierachy($group->getRoles()));
            $em->flush();
            $this->addFlash('info', $this->get('translator')->trans('group.was.edited.successfully'));
            return $this->redirectToRoute('anar_blog_panel_group_index');
        }

        return $this->render('AnarBlogPanelBundle:Group:new.html.twig', array(
            'group'   => $group,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Deletes a Group entity.
     *
     */
    public function deleteAction(Request $request, $groupId)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('group_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $group = $em->getRepository('AnarEngineBundle:Group')->find($groupId);

            if (!$group or $group->isLocked()) {
                $status = array(
                    'code' => 404,
                    'messages' => $translator->trans('group.is.not.exists'),
                );
            } elseif ($group->isDefault()) {
                $status = array(
                    'code' => 400,
                    'messages' => $translator->trans('you.can.not.delete.default.group'),
                );
            } else {
                $em->remove($group);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('group.is.deleted'),
                );
            }
        } else {
            $status = array(
                'code' => 400,
                'message' => $translator->trans('token.is.invalid'),
            );
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array()
        )))->setStatusCode($status['code']);
    }

    public function usersAction($groupId)
    {
        $groupRepo = $this->getDoctrine()->getRepository('AnarEngineBundle:Group');
        $group = $groupRepo->get($groupId);

        $form = $this->createSearchForm($groupId);
        $token = $this->get('security.csrf.token_manager')->getToken('group_users');

        return $this->render('AnarBlogPanelBundle:User:index.html.twig', array(
            'group' => $group,
            'searchForm' => $form->createView(),
            'token' => $token,
        ));
    }

    private function createSearchForm($groupId)
    {
        $form = $this->createForm('user_search', null, array(
            'action' => $this->generateUrl('anar_blog_panel_group_user_search', array('groupId' => $groupId)),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'search'));

        return $form;
    }

    public function searchAction(Request $request, $groupId)
    {
        $form = $this->createSearchForm($groupId);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $userRepository = $this->getDoctrine()->getRepository('AnarEngineBundle:User');
            $usersQuery = $userRepository->getUsersQueryFilterBy($form->getData());
            $users = $usersQuery->setMaxResults(100)->getResult();
            return new JsonResponse(array(
                'status' => array(
                    'code' => $statusCode = (count($users) == 0) ? 404 : 200,
                    'message' => (count($users) == 0) ? $this->get('translator')->trans('not.found') : 'OK'
                ),
                'response' => array(
                    'users' => (count($users) != 0) ? array(
                        'id' => $users[0]->getId(),
                        'username' => $users[0]->getUsername(),
                        'email' => $users[0]->getEmail(),
                        'fname' => $users[0]->getFname(),
                        'lname' => $users[0]->getLname(),
                        'staffCode' => $users[0]->getStaffCode(),
                        'grade' => $users[0]->getGrade()->getName(),
                        'image' => '',
                    ) : array(),
                )
            ), $statusCode);
        } else {
            return new JsonResponse(array(
                'status' => array(
                    'code' => 400,
                    'message' => $this->get('translator')->trans('form.is.invalid')
                ),
                'response' => array(
                    'users' => array()
                )
            ), 400);
        }
    }

    public function addUserAction(Request $request, $groupId, $userId)
    {
        $translator = $this->get('translator');
        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('group_users', $token)) {
            $em = $this->getDoctrine()->getManager();
            $group = $em->find('AnarEngineBundle:Group', $groupId);
            $user = $em->find('AnarEngineBundle:User', $userId);
            if ($user and $group) {
                $user->addGroup($group);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('user.was.added.to.group'),
                );
            } else {
                $status = array(
                    'code' => 400,
                    $translator->trans('item.is.not.exists'),
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
            'response' => array()
        ), $status['code']);
    }

    public function deleteUserAction(Request $request, $groupId, $userId)
    {
        $translator = $this->get('translator');
        $token = $request->request->get('token');

        if ($this->isCsrfTokenValid('group_users', $token)) {
            $em = $this->getDoctrine()->getManager();
            $group = $em->find('AnarEngineBundle:Group', $groupId);
            $user = $em->find('AnarEngineBundle:User', $userId);
            if ($user and $group) {
                $user->removeGroup($group);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('user.was.deleted.from.group'),
                );
            } else {
                $status = array(
                    'code' => 400,
                    $translator->trans('item.is.not.exists'),
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
            'response' => array()
        ), $status['code']);
    }
}