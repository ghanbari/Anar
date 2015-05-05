<?php

namespace Anar\LinkBundle\Controller\Backend;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\LinkBundle\Entity\Link;
use Anar\LinkBundle\Form\LinkType;

/**
 * Link controller.
 *
 */
class LinkController extends Controller implements AdminInterface
{

    /**
     * Lists all Link entities.
     *
     */
    public function indexAction(Request $request, $page)
    {
        $linkRepo = $this->getDoctrine()->getRepository('AnarLinkBundle:Link');
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $paginator = $this->get('knp_paginator');
        $settings = $this->get('vbee.manager.setting');

        $qb = $linkRepo->getFilterByBlogQueryBuilder($blog->getId());
        $links = $paginator->paginate($qb, $page, $settings->get('blogpanel.item_per_page'));
        $token = $this->get('security.csrf.token_manager')->refreshToken('link_delete');

        return $this->render(
            'AnarLinkBundle:Backend/Link:index.html.twig',
            array(
                'links' => $links,
                'token' => $token,
            )
        );
    }

    /**
     * Displays a form to create a new Link entity.
     *
     */
    public function newAction()
    {
        $link = new Link();
        $form = $this->createCreateForm($link);

        return $this->render('AnarLinkBundle:Backend/Link:new.html.twig', array(
            'link'   => $link,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new Link entity.
     *
     */
    public function createAction(Request $request)
    {
        $link = new Link();
        $form = $this->createCreateForm($link);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $blog = $this->get('anar_engine.manager.blog')->getBlog();
            $link->setBlog($blog);
            $em = $this->getDoctrine()->getManager();
            $em->persist($link);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('link.was.created.successfully'));
            return $this->redirectToRoute('anar_link_backend_index');
        }

        return $this->render('AnarLinkBundle:Backend/Link:new.html.twig', array(
            'link' => $link,
            'form' => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a form to create a Link entity.
     *
     * @param Link $link The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Link $link)
    {
        $form = $this->createForm(new LinkType(), $link, array(
            'action' => $this->generateUrl('anar_link_backend_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Link entity.
     *
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $link = $em->getRepository('AnarLinkBundle:Link')->find($id);

        if (!$link) {
            $this->addFlash('error', $this->get('translator')->trans('link.is.not.exists'));
            $this->redirectToRoute('anar_link_backend_index');
        }

        $form = $this->createEditForm($link);

        return $this->render('AnarLinkBundle:Backend/Link:new.html.twig', array(
            'link'   => $link,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
    * Creates a form to edit a Link entity.
    *
    * @param Link $link The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Link $link)
    {
        $form = $this->createForm(new LinkType(), $link, array(
            'action' => $this->generateUrl('anar_link_backend_update', array('id' => $link->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Link entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $link = $em->getRepository('AnarLinkBundle:Link')->find($id);

        if (!$link) {
            $this->addFlash('error', $this->get('translator')->trans('link.is.not.exists'));
            $this->redirectToRoute('anar_link_backend_index');
        }

        $form = $this->createEditForm($link);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->flush();
            $this->addFlash('info', $this->get('translator')->trans('link.was.edited.successfully'));
            return $this->redirectToRoute('anar_link_backend_index');
        }

        return $this->render('AnarLinkBundle:Backend/Link:new.html.twig', array(
            'link'   => $link,
            'form'   => $form->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Deletes a Link entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('link_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $link = $em->getRepository('AnarLinkBundle:Link')->find($id);

            if (!$link) {
                $status = array(
                    'code' => 404,
                    'messages' => $translator->trans('link.is.not.exists')
                );
            } else {
                $em->remove($link);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('link.is.deleted')
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
