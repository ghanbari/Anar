<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\RoleInterface;

/**
 * Role
 */
class Role implements RoleInterface
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
     * @var string
     */
    private $role;

    /**
     * @var App
     */
    private $app;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $groups;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $children;

    /**
     * @var Role
     */
    private $parent;

    /**
     * Constructor.
     *
     * @param string $role The role name
     * @param App $app
     */
    public function __construct($name, $role, $app=null, $parent=null)
    {
        $this->name = $name;
        $this->role = strtoupper($role);
        $this->app  = $app;
        $this->groups = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->parent = $parent;
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
     * Set name
     *
     * @param string $name
     * @return Role
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
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string 
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set app
     *
     * @param App $app
     * @return Role
     */
    public function setApp(App $app = null)
    {
        $this->app = $app;

        return $this;
    }

    /**
     * Get app
     *
     * @return App
     */
    public function getApp()
    {
        return $this->app;
    }

    /**
     * Add groups
     *
     * @param Group $groups
     * @return Role
     */
    public function addGroup(Group $groups)
    {
        $this->groups[] = $groups;

        return $this;
    }

    /**
     * Remove groups
     *
     * @param Group $groups
     */
    public function removeGroup(Group $groups)
    {
        $this->groups->removeElement($groups);
    }

    /**
     * Get groups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Add children
     *
     * @param Role $children
     * @return Role
     */
    public function addChild(Role $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param Role $children
     */
    public function removeChild(Role $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param Role $parent
     * @return Role
     */
    public function setParent(Role $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return Role
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->role;
    }
}
