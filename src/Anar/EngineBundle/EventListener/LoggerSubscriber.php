<?php

namespace Anar\EngineBundle\EventListener;

use Anar\EngineBundle\Entity\Admin;
use Anar\EngineBundle\Entity\Log;
use Anar\EngineBundle\Entity\User;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;
use Symfony\Component\Translation\DataCollectorTranslator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class LoggerSubscriber extends ContainerAware implements EventSubscriber
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var DataCollectorTranslator
     */
    private $translator;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * @param RequestStack $requestStack
     * @param DataCollectorTranslator $translator
     * @param TokenStorage $tokenStorage
     */
    public function __construct(RequestStack $requestStack, DataCollectorTranslator $translator, TokenStorage $tokenStorage)
    {
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::preRemove,
            Events::postPersist,
            Events::postUpdate,
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $this->log($args, 'insert');
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->log($args, 'update');
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preRemove(LifecycleEventArgs $args)
    {
        $this->log($args, 'remove');
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function log(LifecycleEventArgs $args, $event)
    {
        $entity = $args->getObject();
        $em = $args->getObjectManager();

        if ($entity instanceof Log
            || is_null($this->tokenStorage->getToken())
            || (
                ($entity instanceof User or $entity instanceof Admin)
                && $this->tokenStorage->getToken()->getUsername() === $entity->getUsername()
            )
        ) {
            return;
        }

        $blog = $this->container->get('anar_engine.manager.blog')->getBlog();
        $request = $this->requestStack->getMasterRequest();
        if (!is_null($request)) {
            $routeParams = $request->attributes->all();
            if (!$entity instanceof User) {
                $postParams = $request->request->all();
            } else {
                $postParams = array();
            }
        } else {
            $routeParams = null;
            $postParams = null;
        }

        $now = new \DateTime();
        $entityName = strtolower(trim(substr(get_class($entity), strrpos(get_class($entity), '\\')+1)));
        $message = 'مدیر ' . $this->tokenStorage->getToken()->getUsername() . ' در ساعت ' . $now->format('H:i:s') .
            ' در تاریخ ' . $now->format('Y/m/d') . '، ' . $this->translator->trans($entityName, array(), null, 'fa') .
            ' با شناسه ' . $entity->getId() . ' را ' . $this->translator->trans($event, array(), null, 'fa') . ' کرد.';

        $log = new Log();
        $log
            ->setBlog($blog)
            ->setEntity(get_class($entity))
            ->setEvent($event)
            ->setMessage($message)
            ->setPostParams($postParams)
            ->setRouteParams($routeParams);
        $em->persist($log);
        $em->flush();
    }
}