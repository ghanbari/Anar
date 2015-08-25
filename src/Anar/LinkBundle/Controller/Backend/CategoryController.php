<?php

namespace Anar\LinkBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\LinkBundle\Entity\Category;
use Anar\LinkBundle\Form\CategoryType;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{

    /**
     * Lists all Category entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $categories = $em->getRepository('AnarLinkBundle:Category')->findByBlog($blog);
        $token = $this->get('security.csrf.token_manager')->refreshToken('category_delete');

        return $this->render('AnarLinkBundle:Backend/Category:index.html.twig', array(
            'categories' => $categories,
            'token' => $token,
        ));
    }

    /**
     * Displays a form to create a new Category entity.
     *
     */
    public function newAction()
    {
        $category = new Category();
        $form   = $this->createCreateForm($category);

        return $this->render('AnarLinkBundle:Backend/Category:new.html.twig', array(
            'category' => $category,
            'form'     => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new Category entity.
     *
     */
    public function createAction(Request $request)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $category = new Category();
        $category->setBlog($blog);
        $form = $this->createCreateForm($category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('category.is.created'));
            return $this->redirectToRoute('anar_link_backend_category_index');
        }

        return $this->render('AnarLinkBundle:Backend/Category:new.html.twig', array(
            'category' => $category,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $category The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $category)
    {
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('anar_link_backend_category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AnarLinkBundle:Category')->find($id);

        if (!$category) {
            $this->addFlash('error', $this->get('translator')->trans('category.is.not.exists'));
            $this->redirectToRoute('anar_link_backend_category_index');
        }

        $form = $this->createEditForm($category);

        return $this->render('AnarLinkBundle:Backend/Category:new.html.twig', array(
            'category' => $category,
            'form'     => $form->createView(),
            'action'   => 'update',
        ));
    }

    /**
    * Creates a form to edit a Category entity.
    *
    * @param Category $category The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Category $category)
    {
        $form = $this->createForm(new CategoryType(), $category, array(
            'action' => $this->generateUrl('anar_link_backend_category_update', array('id' => $category->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Category entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AnarLinkBundle:Category')->find($id);

        if (!$category) {
            $this->addFlash('error', $this->get('translator')->trans('category.is.not.exists'));
            $this->redirectToRoute('anar_link_backend_category_index');
        }

        $form = $this->createEditForm($category);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('category.is.updated'));
            return $this->redirectToRoute('anar_link_backend_category_index');
        }

        return $this->render('AnarLinkBundle:Backend/Category:new.html.twig', array(
            'category' => $category,
            'form'     => $form->createView(),
            'action'   => 'update',
        ));
    }

    /**
     * Deletes a Category entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('category_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('AnarLinkBundle:Category')->find($id);

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
