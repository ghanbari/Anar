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

        if (!($controller[0] instanceof AdminInterface)) {
            return;
        }

        #Set fallback for content in panels
        $this->container->get('stof_doctrine_extensions.listener.translatable')->setTranslationFallback(true);

        $bundleName = str_replace('\\', '', strstr(get_class($controller[0]), 'Bundle', true)) . 'Bundle';

        $apps = array();
        foreach ($this->container->get('anar_engine.manager.blog')->getBlog()->getApps() as $app) {
            $apps[] = $app->getName();
        }

        if (!in_array($bundleName, $apps)) {
            VarDumper::dump(array(
               'bundleName' => $bundleName,
                'apps' => $apps,
            ));
            $event->setController('AnarBlogPanelBundle:Desktop:home');
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