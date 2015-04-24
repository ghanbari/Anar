<?php

namespace Anar\BlogPanelBundle\EventListener;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\VarDumper\VarDumper;

class AuthenticationListener
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param FilterControllerEvent $event
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $token = $this->container->get('security.token_storage')->getToken();
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if (!($controller[0] instanceof AdminInterface) || is_null($token)) {
            return;
        }


        $bundleName = str_replace('\\', '', strstr(get_class($controller[0]), 'Bundle', true)) . 'Bundle';

        if (!$this->container->get('request_stack')->getMasterRequest()->attributes->has('blogName')) {
            $event->setController(array($this->container->get('anar_blog_panel.controller.desktop'), 'homeAction'));
            return;
        }

        $apps = array();
        foreach ($this->container->get('anar_engine.manager.blog')->getBlog()->getApps() as $app) {
            $apps[] = $app->getName();
        }

        if (!in_array($bundleName, $apps)) {
            VarDumper::dump(array(
               'bundleName' => $bundleName,
                'apps' => $apps,
            ));
            $event->setController(array($this->container->get('anar_blog_panel.controller.desktop'), 'homeAction'));
            return;
        }

        $neededRole = str_replace('\\', '_', get_class($controller[0])) .'__'. str_replace('Action', '', $controller[1]);
        $neededRole = str_replace('Controller_', '', $neededRole);
        $neededRole = str_replace('Bundle', '', $neededRole);
        $neededRole = strtoupper($neededRole);

        $userRoles = $this->container->get('doctrine')->getRepository('AnarEngineBundle:User')->getRolesFilterByBlog(
            $token->getUser()->getId(),
            $this->container->get('anar_engine.manager.blog')->getBlog()->getId()
        );

        if (!(in_array($neededRole, $userRoles) or in_array('ROLE_ADMIN', $userRoles))) {
            VarDumper::dump(array(
                'bundleName' => $bundleName,
                'apps' => $apps,
                'userRoles' => $userRoles,
            ));
            throw new AccessDeniedException();
        }
    }
}