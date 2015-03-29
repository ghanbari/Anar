<?php

namespace Anar\SuperPanelBundle\Controller;

use Anar\EngineBundle\Entity\BlogRepository;
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
    public function indexAction()
    {
        $repo = $this->getRepository();

        return $this->render(
            'AnarSuperPanelBundle:Blog:index.html.twig',
            array(
                'tree' => json_encode($repo->getTreeForJstree()),
                'token' => $this->get('form.csrf_provider')->generateCsrfToken('blog_delete')
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

            $request->getSession()->getFlashBag()->add('info', 'Blog was created, click on link');
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

        $form->add('submit', 'submit');

        return $form;
    }

    /**
     * Displays a form to edit an existing Blog entity.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('AnarEngineBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm = $this->createEditForm($blog);

        return $this->render('AnarSuperPanelBundle:Blog:new.html.twig', array(
            'blog'      => $blog,
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

        $form->add('submit', 'submit', array('label' => 'Update'));

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
            throw $this->createNotFoundException('Unable to find Blog entity.');
        }

        $editForm = $this->createEditForm($blog);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $request->getSession()->getFlashBag()->add('info', 'Blog Is Edited');
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
        if ($this->get('form.csrf_provider')->isCsrfTokenValid('blog_delete', $request->request->get('token'))) {
            $form = $this->createDeleteForm($id);
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $entity = $em->getRepository('AnarEngineBundle:Blog')->find($id);

                if (!$entity) {
                    throw $this->createNotFoundException('Unable to find Blog entity.');
                }

                $em->remove($entity);
                $em->flush();
            }
            $status = array(
                'code' => 200,
                'message' => 'OK'
            );
        } else {
            $status = array(
                'code' => 400,
                'message' => 'Token is invalid'
            );
        }
        return new JsonResponse(array(
            'status' => $status,
            'response' => array()
        ));
    }

    /**
     * @param $name
     * @return JsonResponse
     */
    public function checkNameAction($name)
    {
        if ($this->getRepository()->findOneByName($name)) {
            $status = array(
                'code' => 0,
                'message' => 'This name is exists!',
            );
        } else {
            if (is_string($name) and preg_match('/^[a-z]{4,100}$/', $name)) {
                $status = array(
                    'code' => 200,
                    'message' => 'You can use this name',
                );
            } else {
                $status = array(
                    'code' => 400,
                    'message' => 'Username have not allowed character',
                );
            }
        }

        return new JsonResponse(array(
            'status' => $status,
            'response' => array(
                'username' => $name
            )
        ));
    }
}
