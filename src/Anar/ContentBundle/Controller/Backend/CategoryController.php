<?php

namespace Anar\ContentBundle\Controller\Backend;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anar\ContentBundle\Entity\Category;
use Anar\ContentBundle\Form\CategoryType;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller implements AdminInterface
{
    /**
     * Lists all Category entities.
     *
     */
    public function indexAction($page)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $doctrine = $this->getDoctrine();

        $query = $doctrine->getRepository('AnarContentBundle:Category')->getQueryFilterByBlog($blog->getId());

        $categories = $this->get('knp_paginator')->paginate(
            $query,
            $page,
            $this->get('vbee.manager.setting')->get('blogpanel.item_per_page')
        );

        $token = $this->get('security.csrf.token_manager')->refreshToken('category_delete');

        return $this->render('AnarContentBundle:Backend/Category:index.html.twig', array(
            'categories' => $categories,
            'token' => $token,
        ));
    }

    /**
     * Displays a form to create a new Category category.
     *
     */
    public function newAction()
    {
        $category = new Category();
        $form = $this->createCreateForm($category);

        return $this->render('AnarContentBundle:Backend/Category:new.html.twig', array(
            'category' => $category,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new Category category.
     *
     */
    public function createAction(Request $request)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $category = new Category();
        $form = $this->createCreateForm($category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $category->setBlog($blog);
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('category.is.created'));
            return $this->redirectToRoute('anar_content_backend_category_index');
        }

        return $this->render('AnarContentBundle:Backend/Category:new.html.twig', array(
            'category' => $category,
            'form'     => $form->createView(),
            'action'   => 'create',
        ));
    }

    /**
     * Creates a form to create a Category category.
     *
     * @param Category $category The category
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $category)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $form = $this->createForm(new CategoryType($blog), $category, array(
            'action' => $this->generateUrl('anar_content_backend_category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Category category.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('AnarContentBundle:Category')->find($id);

        if (!$category) {
            $this->addFlash('error', $this->get('translator')->trans('category.is.not.exists'));
            return $this->redirectToRoute('anar_content_backend_article_index');
        }

        $form = $this->createEditForm($category);

        return $this->render('AnarContentBundle:Backend/Category:new.html.twig', array(
            'category' => $category,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
    * Creates a form to edit a Category category.
    *
    * @param Category $category The category
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Category $category)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $form = $this->createForm(new CategoryType($blog), $category, array(
            'action' => $this->generateUrl('anar_content_backend_category_update', array('id' => $category->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Category category.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AnarContentBundle:Category')->find($id);

        if (!$category) {
            $this->addFlash('error', $this->get('translator')->trans('category.is.not.exists'));
            return $this->redirectToRoute('anar_content_backend_category_index');
        }

        $form = $this->createEditForm($category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('category.was.edited.successfully'));
            $this->redirectToRoute('anar_content_backend_category_index');
        }

        return $this->render('AnarContentBundle:Backend/Category:new.html.twig', array(
            'category' => $category,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Deletes a Category category.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('category_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('AnarContentBundle:Category')->find($id);

            if (!$category) {
                $status = array(
                    'code' => 404,
                    'messages' => $translator->trans('category.is.not.exists')
                );
            } else {
                $em->remove($category);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('category.is.deleted')
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
}
