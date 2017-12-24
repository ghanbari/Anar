<?php

namespace Anar\HomeBundle\Menu;

use Knp\Menu\Loader\NodeLoader;
use Anar\EngineBundle\Menu\Loader\ArrayLoader as BlogArrayLoader;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\VarDumper\VarDumper;

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

    public function contentCategoryMenu()
    {
        $factory = $this->container->get('knp_menu.factory');
        $translator = $this->container->get('translator');
        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();
        $categoryRepo = $this->container->get('doctrine')->getRepository('AnarContentBundle:Category');
        $roots = $categoryRepo->findBy(array('blog' => $blog->getId(), 'parent' => null));
        $loader = new NodeLoader($factory);

        $menu = $factory->createItem($translator->trans('content.category'));
        foreach ($roots as $root) {
            $menu->addChild($loader->load($root));
        }

        return $menu;
    }

    public function organizationStructureMenu()
    {
        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();

        $factory = $this->container->get('knp_menu.factory');
        $loader = new BlogArrayLoader($factory, $this->container->getParameter('address_type'));
        $doctrine = $this->container->get('doctrine');
        $repo = $doctrine->getRepository('AnarEngineBundle:Blog');
        $repo->setChildrenIndex('children');

        $query = $doctrine->getEntityManager()
            ->createQueryBuilder()
            ->select('node')
            ->from('AnarEngineBundle:Blog', 'node')
            ->orderBy('node.root, node.lft', 'ASC')
            ->where('node.root = 1')
            ->getQuery();

        $query->setHint(
            \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
        );

        $data = $repo->buildTree($query->getArrayResult());

        $menu = $factory->createItem('root');
        $menu->addChild($loader->load($data[0]));

        $apps = array();
        foreach ($blog->getApps() as $app) {
            $apps[] = $app->getName();
        }

        if (in_array('AnarMenuBundle', $apps)) {
            $menuHeaders = $this->headerMenu();

            foreach ($menuHeaders->getChildren() as $menuHeader) {
                $menuHeader->setParent();
                $menu->addChild($menuHeader);
            }
        }

        if (in_array('AnarContentBundle', $apps)) {
            $menu->addChild($this->contentCategoryMenu());
            $menu->addChild($this->content());
        }

        if (in_array('AnarProfessorBundle', $apps)) {
            $menu->addChild($this->profile());
        }

        if (in_array('AnarContactBundle', $apps)) {
            $menu->addChild($this->contact());
        }

        return $menu;
    }

    public function profile()
    {
        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();
        $factory = $this->container->get('knp_menu.factory');
        $translator = $this->container->get('translator');
        $menu = $factory->createItem('profile', array(
            /** @Ignore */
            'label' => $translator->trans('profile'),
            'route' => $this->container->getParameter('address_type') == 'domain' ? 'anar_professor_frontend_profile_show' : 'anar_professor_frontend_profile_show_path',
            'routeParameters' => array(
                'blogName' => $blog->getName(),
            )
        ));
        return $menu;
    }

    public function contact()
    {
        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();
        $factory = $this->container->get('knp_menu.factory');
        $translator = $this->container->get('translator');
        $menu = $factory->createItem('contact', array(
            /** @Ignore */
            'label' => $translator->trans('contact'),
            'route' => $this->container->getParameter('address_type') == 'domain' ? 'anar_contact_frontend_new' : 'anar_contact_frontend_new_path',
            'routeParameters' => array(
                'blogName' => $blog->getName(),
            )
        ));
        return $menu;
    }

    public function content()
    {
        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();
        $factory = $this->container->get('knp_menu.factory');
        $translator = $this->container->get('translator');
        $menu = $factory->createItem('content', array(
            /** @Ignore */
            'label' => $translator->trans('content'),
            'route' => $this->container->getParameter('address_type') == 'domain' ? 'anar_content_frontend_article_index' : 'anar_content_frontend_article_index_path',
            'routeParameters' => array(
                'blogName' => $blog->getName(),
            )
        ));
        return $menu;
    }
}