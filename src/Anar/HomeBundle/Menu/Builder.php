<?php

namespace Anar\HomeBundle\Menu;

use Knp\Menu\Loader\NodeLoader;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function headerMenu()
    {
        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();
        $factory = $this->container->get('knp_menu.factory');
        $menuRepo = $this->container->get('doctrine')->getRepository('AnarMenuBundle:Menu');
        $root = $menuRepo->findOneBy(array('parent' => null, 'blog' => $blog->getId()));

        $loader = new NodeLoader($factory);
        return $loader->load($root);
    }

    public function organizationStructureMenu()
    {
        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();
        $factory = $this->container->get('knp_menu.factory');
        $translator = $this->container->get('translator');

        $menuHeaders = $this->headerMenu();

        $loader = new NodeLoader($factory);
        $menu = $factory->createItem($translator->trans('subset'));
        $menu->addChild($loader->load($blog));

        foreach ($menuHeaders->getChildren() as $menuHeader) {
            $menuHeader->setParent();
            $menu->addChild($menuHeader);
        }

        return $menu;
    }
}