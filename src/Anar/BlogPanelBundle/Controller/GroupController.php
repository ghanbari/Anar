<?php

namespace Anar\BlogPanelBundle\Controller;

use Anar\BlogPanelBundle\Form\GroupType;
use Anar\EngineBundle\Entity\Group;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GroupController extends Controller
{
    public function indexAction()
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $groups = $blog->getGroups();

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
        $form = $this->createCreateForm();

        return $this->render(
            'AnarBlogPanelBundle:Group:new.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    private function createCreateForm()
    {
        $form = $this->createForm(new GroupType(), array(), array(
            'action' => $this->generateUrl('anar_blog_panel_group_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'create'));

        return $form;
    }
}