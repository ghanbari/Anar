<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\GroupInterface;

/**
 * Group
 */
class Group implements GroupInterface
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var Blog
     */
    private $blog;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $default;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $translations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $roles;

    /**
     * @var string
     */
    private $currentLocale;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * @param $name
     * @param array $roles
     * @param boolean $default
     */
    public function __construct($name, $roles=array(), $default=false)
    {
        $this->name = $name;
        $this->default = $default;
        $this->translations = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->setRoles($roles);
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
     * Set blog
     *
     * @param Blog $blog
     * @return Group
     */
    public function setBlog(Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set default
     *
     * @param boolean $default
     * @return Group
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Is default
     *
     * @return boolean
     */
    public function isDefault()
    {
        return $this->default;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Group
     */
    public function setCreatedAt(\DateTime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Group
     */
    public function setUpdatedAt(\DateTime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Add translations
     *
     * @param GroupTranslation $translations
     * @return Group
     */
    public function addTranslation(GroupTranslation $translations)
    {
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param GroupTranslation $translations
     */
    public function removeTranslation(GroupTranslation $translations)
    {
        $this->translations->removeElement($translations);
    }

    /**
     * Get translations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Group
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
     * Add roles
     *
     * @param Role $roles
     * @return Group
     */
    public function addRole($roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param Role $roles
     * @return null
     */
    public function removeRole($roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @inheritdoc
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * @param string $role
     *
     * @return boolean
     */
    public function hasRole($role)
    {
        return $this->roles->contains($role);
    }

    /**
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles)
    {
        $this->roles = new ArrayCollection($roles);
        return $this;
    }

    /**
     * Get default
     *
     * @return boolean 
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @return string
     */
    public function getCurrentLocale()
    {
        return $this->currentLocale;
    }

    /**
     * @param string $currentLocale
     */
    public function setCurrentLocale($currentLocale)
    {
        $this->currentLocale = $currentLocale;
    }

    /**
     * Add users
     *
     * @param User $users
     * @return Group
     */
    public function addUser(User $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param User $users
     */
    public function removeUser(User $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }
}
