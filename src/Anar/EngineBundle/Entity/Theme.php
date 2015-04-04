<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Theme
 */
class Theme
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $direction;

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
     * Set name
     *
     * @param string $name
     * @return Theme
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set direction
     *
     * @param array $direction
     * @return Theme
     */
    public function setDirection(array $direction)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Is it a left to right theme
     *
     * @return bool
     */
    public function isLtr()
    {
        return in_array('ltr', $this->direction);
    }

    /**
     * Is it a right to left theme
     *
     * @return bool
     */
    public function isRtl()
    {
        return in_array('rtl', $this->direction);
    }

    /**
     * Get direction
     *
     * @return array 
     */
    public function getDirection()
    {
        return $this->direction;
    }
}
