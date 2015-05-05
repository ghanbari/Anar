<?php

namespace Anar\EngineBundle\Doctrine;

use Anar\EngineBundle\Entity\Language;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\HttpFoundation\RequestStack;

class LanguageManager
{
    /**
     * @var Language
     */
    private static $language;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @param Registry $doctrine
     * @param RequestStack $requestStack
     */
    public function __construct(Registry $doctrine, RequestStack $requestStack)
    {
        $this->doctrine = $doctrine;
        $this->requestStack = $requestStack;
    }

    public function getLanguage()
    {
        if (is_null(static::$language)) {
            $request = $this->requestStack->getMasterRequest();

            if (is_null($request)) {
                return;
            }

            $locale = $request->getLocale();
            static::$language = $this->doctrine->getRepository('AnarEngineBundle:Language')->findOneByCode($locale);
        }

        return static::$language;
    }
}