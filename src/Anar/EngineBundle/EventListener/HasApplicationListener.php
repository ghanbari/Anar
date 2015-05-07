<?php

namespace Anar\EngineBundle\EventListener;

use Anar\EngineBundle\Doctrine\BlogManager;
use Anar\EngineBundle\Entity\App;
use Anar\EngineBundle\Interfaces\ApplicationInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HasApplicationListener
{
    private $blogManager;

    private $doctrine;

    public function __construct(BlogManager $blogManager, Registry $doctrine)
    {
        $this->blogManager = $blogManager;
        $this->doctrine = $doctrine;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller  = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ((!$controller[0] instanceof ApplicationInterface)) {
            return;
        }

        $bundleName = str_replace('\\', '', strstr(get_class($controller[0]), 'Bundle', true)) . 'Bundle';
        $apps = $this->blogManager->getBlog()->getApps();

        foreach ($apps as $app) {
            if ($app->getName() == $bundleName) {
                return;
            }
        }

        $appRepo = $this->doctrine->getRepository('AnarEngineBundle:App');
        /** @var App $app */
        $app = $appRepo->findOneByName($bundleName);

        if (is_null($app)) {
            throw new NotFoundHttpException('This tool is not exists!');
        }

        if (strtolower($app->getType()) == 'module') {
            $event->setController(function () {
                return new Response('');
            });
        } else {
            throw new NotFoundHttpException();
        }
    }
}