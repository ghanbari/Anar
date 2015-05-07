<?php

namespace Anar\MenuBundle\Controller;

use Knp\Menu\Loader\NodeLoader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        $factory = $this->get('knp_menu.factory');
        $loader = new NodeLoader($factory);
        $doctrine = $this->getDoctrine();
        $root = $doctrine->getRepository('AnarMenuBundle:Menu')->findOneBy(array('parent' => null));
        $menu = $loader->load($root);

        return $this->render('AnarMenuBundle:Default:index.html.twig', array('menu' => $menu));
    }
}
