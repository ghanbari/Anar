<?php

namespace Anar\SuperPanelBundle\Controller;

use Anar\EngineBundle\Entity\BlogRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\EngineBundle\Entity\Blog;
use Anar\SuperPanelBundle\Form\BlogType;

/**
 * Blog controller.
 *
 */
class BlogController extends Controller
{
    /**
     * @return BlogRepository
     */
    private function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('AnarEngineBundle:Blog');
    }

    /**
     * Lists all Blog entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getRepository();

        return $this->render(
            'AnarSuperPanelBundle:Blog:index.' . $request->getRequestFormat() . '.twig',
            array(
                'tree' => json_encode($repo->getTreeForJstree()),
                'token' => $this->get('security.csrf.token_manager')->refreshToken('blog_delete'),
            )
        );
    }

    /**
     * Displays a form to create a new Blog entity.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $blog = new Blog();
        $form = $this->createCreateForm($blog);

        return $this->render('AnarSuperPanelBundle:Blog:new.html.twig', array(
            'blog' => $blog,
            'form' => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new Blog entity.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $blog = new Blog();
        $form = $this->createCreateForm($blog);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('blog.was.created.successfully'));
            return $this->redirect($this->generateUrl('anar_super_panel_blog_index'));
        }

        return $this->render('AnarSuperPanelBundle:Blog:new.html.twig', array(
            'blog' => $blog,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a form to create a Blog entity.
     *
     * @param Blog $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Blog $entity)
    {
        $form = $this->createForm(new BlogType(), $entity, array(
            'action' => $this->generateUrl('anar_super_panel_blog_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Blog entity.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('AnarEngineBundle:Blog')->find($id);

        if (!$blog) {
            $this->add('error', $this->get('translator')->trans('blog.is.not.exists'));
            return $this->redirectToRoute('anar_super_panel_blog_index');
        }

        $editForm = $this->createEditForm($blog);

        return $this->render('AnarSuperPanelBundle:Blog:new.html.twig', array(
            'blog'   => $blog,
            'form'   => $editForm->createView(),
            'action' => 'update',
        ));
    }

    /**
    * Creates a form to edit a Blog entity.
    *
    * @param Blog $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Blog $entity)
    {
        $form = $this->createForm(new BlogType(), $entity, array(
            'action' => $this->generateUrl('anar_super_panel_blog_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->remove('name');
        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Blog entity.
     *
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('AnarEngineBundle:Blog')->find($id);

        if (!$blog) {
            $this->addFlash('error', $this->get('translator')->trans('blog.is.not.exists'));
            return $this->redirectToRoute('anar_super_panel_blog_index');
        }

        $editForm = $this->createEditForm($blog);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('blog.was.edited.successfully'));
            return $this->redirect($this->generateUrl('anar_super_panel_blog_index'));
        }

        return $this->render('AnarSuperPanelBundle:Blog:new.html.twig', array(
            'blog'      => $blog,
            'form'   => $editForm->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Deletes a Blog entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('blog_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AnarEngineBundle:Blog')->find($id);

            if (!$entity) {
                $status = array(
                    'code' => 404,
                    'message' => $translator->trans('not.found')
                );
            } else {
                $em->remove($entity);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('blog.is.deleted')
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
     * @param $name
     * @return JsonResponse
     */
    public function checkNameAction($name)
    {
        $translator = $this->get('translator');
        if ($this->getRepository()->findOneByName($name)) {
            $status = array(
                'code' => 403,
                'message' => $translator->trans('name.is.exists'),
            );
        } else {
            if (is_string($name) and preg_match('/^[a-z]{4,100}$/', $name)) {
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('you.can.use.this.name'),
                );
            } else {
                $status = array(
                    'code' => 400,
                    'message' => $translator->trans('name.not.have.valid.character'),
                );
            }
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array(
                'username' => $name
            )
        )))->setStatusCode($status['code']);
    }

    /**
     * Return admin's list of given blog.
     *
     * @param int $id Blog id.
     * @return JsonResponse
     */
    public function adminsListAction($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $blog = $manager->find('AnarEngineBundle:Blog', $id);

        if (!$blog) {
            $status = array(
                'code' => 400,
                'message' => $this->get('translator')->trans('blog.is.not.exists'),
            );
        } else {
            $dql = "SELECT PARTIAL u.{id, username, email, fname, lname, staffCode} FROM AnarEngineBundle:User u JOIN u.groups g JOIN g.blog b JOIN g.roles r WHERE b.id = :blogId AND r.role = 'ROLE_ADMIN' ";
            $users = $manager->createQuery($dql)->setParameter('blogId', $id)->getArrayResult();
            $status = array(
                'code' => 200,
                'message' => 'OK',
            );
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array(
                'users' => $status['code'] == 200 ? $users : array()
            )
        )))->setStatusCode($status['code']);
    }

    public function deleteUserFromAdminsListAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $translator = $this->get('translator');

        $blog = $manager->find('AnarEngineBundle:Blog', $id);

        if (!$blog) {
            return new JsonResponse(array(
                'status' => array(
                    'code' => 400,
                    'message' => $translator->trans('blog.is.not.exists'),
                ),
                'response' => array()
            ));
        }

        $userId = $request->request->get('userId', null);

        if (is_null($userId)) {
            return new JsonResponse(array());
        }

        $user = $manager->find('AnarEngineBundle:User', $userId);

        if (!$user) {
            return new JsonResponse(array(
                'status' => array(
                    'code' => 400,
                    'message' => $translator->trans('user.is.not.exists'),
                ),
                'response' => array()
            ));
        }

        $dql = "SELECT g FROM AnarEngineBundle:Group g JOIN g.users u JOIN g.blog b JOIN g.roles r WHERE b.id = :blogId AND r.role = 'ROLE_ADMIN' AND u.id = :userId";
        try {
            $group = $manager->createQuery($dql)->setParameter('blogId', $id)->setParameter('userId', $userId)->getSingleResult();
            $user->removeGroup($group);
            $manager->flush();
            $status = array(
                'code' => 200,
                'message' => 'OK',
            );
        } catch (NonUniqueResultException $e) {
            $status = array(
                'code' => 500,
                'message' => $translator->trans('system.error'),
            );
        } catch (NoResultException $e) {
            $status = array(
                'code' => 500,
                'message' => $translator->trans('system.error'),
            );
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array()
        )))->setStatusCode($status['code']);

    }
}
