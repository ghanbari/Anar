<?php

namespace Anar\EngineBundle\Entity;

/**
 * AppMenu
 */
class AppMenu
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $icon;

    /**
     * @var \Anar\EngineBundle\Entity\Role
     */
    private $role;

    /**
     * @var \Anar\EngineBundle\Entity\App
     */
    private $app;


    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return AppMenu
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
     * Set route
     *
     * @param string $route
     *
     * @return AppMenu
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set icon
     *
     * @param string $icon
     *
     * @return AppMenu
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * Set role
     *
     * @param \Anar\EngineBundle\Entity\Role $role
     *
     * @return AppMenu
     */
    public function setRole(Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \Anar\EngineBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set app
     *
     * @param \Anar\EngineBundle\Entity\App $app
     *
     * @return AppMenu
     */
    public function setApp(App $app = null)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * Get app
     *
     * @return \Anar\EngineBundle\Entity\App
     */
    public function getApp()
    {
        return $this->app;
    }
}

