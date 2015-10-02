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
     * @var string $locale default locale
     */
    private $locale;

    /**
     * @param Registry $doctrine
     * @param RequestStack $requestStack
     * @param string $locale default locale
     */
    public function __construct(Registry $doctrine, RequestStack $requestStack, $locale)
    {
        $this->doctrine = $doctrine;
        $this->requestStack = $requestStack;
        $this->locale = $locale;
    }

    public function getLanguage()
    {
        if (is_null(static::$language)) {
            $request = $this->requestStack->getMasterRequest();

            if (!is_null($request)) {
                $locale = $request->getLocale();
            } else {
                $locale = $this->locale;
            }

            static::$language = $this->doctrine->getRepository('AnarEngineBundle:Language')->findOneByCode($locale);
        }

        return static::$language;
    }
}