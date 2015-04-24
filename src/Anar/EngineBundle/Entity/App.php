<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * App
 */
class App
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
    private $title;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $blogs;

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
     * @param string $name Bundle name.
     * @param string $title Application name.
     * @param string $type Application type.
     */
    public function __construct($name, $title, $type)
    {
        $this->blogs = new ArrayCollection();
        $this->name = $name;
        $this->title = $title;
        $this->type = $type;
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
     * @return App
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
     * Set title
     *
     * @param string $title
     * @return App
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return App
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add blogs
     *
     * @param Blog $blogs
     * @return App
     */
    public function addBlog(Blog $blogs)
    {
        $this->blogs[] = $blogs;

        return $this;
    }

    /**
     * Remove blogs
     *
     * @param Blog $blogs
     */
    public function removeBlog(Blog $blogs)
    {
        $this->blogs->removeElement($blogs);
    }

    /**
     * Get blogs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBlogs()
    {
        return $this->blogs;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return App
     */
    public function setCreatedAt($createdAt)
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
     * @return App
     */
    public function setUpdatedAt($updatedAt)
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
     * @param AppTranslation $translations
     * @return App
     */
    public function addTranslation(AppTranslation $translations)
    {
        $this->translations[] = $translations;

        return $this;
    }

    /**
     * Remove translations
     *
     * @param AppTranslation $translations
     */
    public function removeTranslation(AppTranslation $translations)
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
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

    /**
     * Add role
     *
     * @param Role $role
     *
     * @return App
     */
    public function addRole(Role $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
