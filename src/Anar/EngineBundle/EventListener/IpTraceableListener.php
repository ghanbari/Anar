<?php

namespace Anar\EngineBundle\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

/**
 * Class DoctrineExtensionListener
 *
 * @package Anar\EngineBundle\EventListener
 */
class IpTraceableListener
{
    /**
     * @var \Gedmo\IpTraceable\IpTraceableListener
     */
    private $ipTraceableListener;

    /**
     * @var Request
     */
    private $request;

    /**
     * @param \Gedmo\IpTraceable\IpTraceableListener $ipTraceableListener
     * @param Request $request
     */
    public function __construct(\Gedmo\IpTraceable\IpTraceableListener $ipTraceableListener, Request $request)
    {
        $this->ipTraceableListener = $ipTraceableListener;
        $this->request = $request;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (null === $this->request) {
            return;
        }

        $ip = $this->request->getClientIp();

        if (null !== $ip) {
            $this->ipTraceableListener->setIpValue($ip);
        }
    }
}