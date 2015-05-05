<?php

namespace Anar\MenuBundle\Controller\Backend;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Anar\MenuBundle\Entity\MenuRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Anar\MenuBundle\Entity\Menu;
use Anar\MenuBundle\Form\MenuType;

/**
 * Menu controller.
 *
 */
class MenuController extends Controller implements AdminInterface
{
    /**
     * @return MenuRepository
     */
    private function getRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('AnarMenuBundle:Menu');
    }

    /**
     * Lists all Menu entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $repo = $this->getRepository();

        return $this->render(
            'AnarMenuBundle:Menu:index.html.twig',
            array(
                'tree' => json_encode($repo->getTreeForJstree()),
                'token' => $this->get('security.csrf.token_manager')->refreshToken('menu_delete'),
            )
        );
    }

    /**
     * Displays a form to create a new Menu entity.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newAction()
    {
        $menu = new Menu();
        $form = $this->createCreateForm($menu);

        return $this->render('AnarMenuBundle:Menu:new.html.twig', array(
            'menu' => $menu,
            'form' => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a new Menu entity.
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $menu = new Menu();
        $form = $this->createCreateForm($menu);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($menu);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('menu.was.created.successfully'));
            return $this->redirect($this->generateUrl('anar_menu_backend_index'));
        }

        return $this->render('AnarMenuBundle:Menu:new.html.twig', array(
            'menu' => $menu,
            'form'   => $form->createView(),
            'action' => 'create',
        ));
    }

    /**
     * Creates a form to create a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('anar_menu_backend_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }

    /**
     * Displays a form to edit an existing Menu entity.
     *
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('AnarMenuBundle:Menu')->find($id);

        if (!$menu) {
            $this->add('error', $this->get('translator')->trans('menu.is.not.exists'));
            return $this->redirectToRoute('anar_super_panel_menu_index');
        }

        $editForm = $this->createEditForm($menu);

        return $this->render('AnarMenuBundle:Menu:new.html.twig', array(
            'menu'   => $menu,
            'form'   => $editForm->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Creates a form to edit a Menu entity.
     *
     * @param Menu $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Menu $entity)
    {
        $form = $this->createForm(new MenuType(), $entity, array(
            'action' => $this->generateUrl('anar_menu_backend_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'update'));

        return $form;
    }

    /**
     * Edits an existing Menu entity.
     *
     * @param Request $request
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $menu = $em->getRepository('AnarMenuBundle:Menu')->find($id);

        if (!$menu) {
            $this->addFlash('error', $this->get('translator')->trans('menu.is.not.exists'));
            return $this->redirectToRoute('anar_super_panel_menu_index');
        }

        $editForm = $this->createEditForm($menu);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('menu.was.edited.successfully'));
            return $this->redirect($this->generateUrl('anar_super_panel_menu_index'));
        }

        return $this->render('AnarMenuBundle:Menu:new.html.twig', array(
            'menu'      => $menu,
            'form'   => $editForm->createView(),
            'action' => 'update',
        ));
    }

    /**
     * Deletes a Menu entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('menu_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AnarMenuBundle:Menu')->find($id);

            if (!$entity) {
                $status = array(
                    'code' => 404,
                    'message' => $translator->trans('not.found')
                );
            } elseif (is_null($entity->getParent())) {
                $status = array(
                    'code' => 400,
                    'message' => $translator->trans('item.can.not.delete')
                );
            } else {
                $em->remove($entity);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('menu.is.deleted')
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
