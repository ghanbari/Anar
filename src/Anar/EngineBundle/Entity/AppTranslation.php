<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppTranslation
 */
class AppTranslation extends Translation
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var \Anar\EngineBundle\Entity\App
     */
    protected $object;

    /**
     * Convenient constructor
     *
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct($locale, $field, $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set object
     *
     * @param \Anar\EngineBundle\Entity\App $object
     * @return AppTranslation
     */
    public function setObject($object)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return \Anar\EngineBundle\Entity\App 
     */
    public function getObject()
    {
        return $this->object;
    }
}
