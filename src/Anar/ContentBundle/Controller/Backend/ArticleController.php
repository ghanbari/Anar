<?php

namespace Anar\ContentBundle\Controller\Backend;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Anar\ContentBundle\Entity\Article;

/**
 * Article controller.
 *
 */
class ArticleController extends Controller implements AdminInterface
{
    /**
     * Lists all Article entities.
     *
     */
    public function indexAction($page)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $doctrine = $this->getDoctrine();
        $query = $doctrine->getRepository('AnarContentBundle:Article')->getFilterByBlogQueryBuilder($blog->getId())
            ->orderBy('a.createdAt', 'DESC');

        $articles = $this->get('knp_paginator')->paginate(
            $query,
            $page,
            $this->get('vbee.manager.setting')->get('blogpanel.item_per_page', 10)
        );

        $token = $this->get('security.csrf.token_manager')->refreshToken('article_delete');

        return $this->render('AnarContentBundle:Backend/Article:index.html.twig', array(
            'articles' => $articles,
            'token' => $token,
        ));
    }

    /**
     * Displays a form to create a new Article article.
     *
     */
    public function newAction()
    {
        $article = new Article();
        $form   = $this->createCreateForm($article);

        return $this->render('AnarContentBundle:Backend/Article:new.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new Article article.
     *
     */
    public function createAction(Request $request)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $article = new Article();
        $article->setBlog($blog);
        $form = $this->createCreateForm($article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('article.is.created'));
            return $this->redirectToRoute('anar_content_backend_article_index');
        }

        return $this->render('AnarContentBundle:Backend/Article:new.html.twig', array(
            'article' => $article,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a form to create a Article article.
     *
     * @param Article $article The article
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Article $article)
    {
        $form = $this->createForm('article', $article, array(
            'action' => $this->generateUrl('anar_content_backend_article_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Article article.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AnarContentBundle:Article')->find($id);

        if (!$article) {
            $this->addFlash('error', $this->get('translator')->trans('article.is.not.exists'));
            return $this->redirectToRoute('anar_content_backend_article_index');
        }

        $form = $this->createEditForm($article);

        return $this->render('AnarContentBundle:Backend/Article:new.html.twig', array(
            'article' => $article,
            'form'    => $form->createView(),
            'action'  => 'update',
        ));
    }

    /**
    * Creates a form to edit a Article article.
    *
    * @param Article $article The article
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Article $article)
    {
        $form = $this->createForm('article', $article, array(
            'action' => $this->generateUrl('anar_content_backend_article_update', array('id' => $article->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Article article.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AnarContentBundle:Article')->find($id);

        if (!$article) {
            $this->addFlash('error', $this->get('translator')->trans('article.is.not.exists'));
            return $this->redirectToRoute('anar_content_backend_article_index');
        }

        $form = $this->createEditForm($article);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('article.was.edited.successfully'));
            return $this->redirectToRoute('anar_content_backend_article_index');
        }

        return $this->render('AnarContentBundle:Backend/Article:new.html.twig', array(
            'article' => $article,
            'form'    => $form->createView(),
            'action'  => 'update',
        ));
    }

    /**
     * Deletes a Article article.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('article_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $article = $em->getRepository('AnarContentBundle:Article')->find($id);

            if (!$article) {
                $status = array(
                    'code' => 404,
                    'messages' => $translator->trans('article.is.not.exists')
                );
            } else {
                $em->remove($article);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('article.is.deleted')
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
