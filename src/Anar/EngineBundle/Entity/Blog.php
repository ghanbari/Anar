<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Knp\Menu\NodeInterface;

/**
 * Blog
 */
class Blog implements NodeInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $onTree;

    /**
     * @var boolean
     */
    private $active;

    /**
     * @var integer
     */
    private $lft;

    /**
     * @var integer
     */
    private $rgt;

    /**
     * @var integer
     */
    private $root;

    /**
     * @var integer
     */
    private $lvl;

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
    private $children;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $translations;

    /**
     * @var \Anar\EngineBundle\Entity\Blog
     */
    private $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $apps;

    /**
     * @var string
     */
    private $currentLocale;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $groups;

    /**
     * @var \Anar\EngineBundle\Entity\Theme
     */
    private $theme;

    /**
     * @var int $drivesize
     */
    private $driveSize;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->apps = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->active = True;
        $this->onTree = True;
        $this->driveSize = 100;
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
     * Set title
     *
     * @param string $title
     * @return Blog
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
     * Set description
     *
     * @param string $description
     * @return Blog
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Blog
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
     * Set onTree
     *
     * @param boolean $onTree
     * @return Blog
     */
    public function setOnTree($onTree)
    {
        $this->onTree = $onTree;

        return $this;
    }


    /**
     * Get onTree
     *
     * @return boolean
     */
    public function isOnTree()
    {
        return $this->onTree;
    }

    /**
     * Get onTree
     *
     * @return boolean 
     */
    public function getOnTree()
    {
        return $this->onTree;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Blog
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Set lft
     *
     * @param integer $lft
     * @return Blog
     */
    public function setLft($lft)
    {
        $this->lft = $lft;

        return $this;
    }

    /**
     * Get lft
     *
     * @return integer 
     */
    public function getLft()
    {
        return $this->lft;
    }

    /**
     * Set rgt
     *
     * @param integer $rgt
     * @return Blog
     */
    public function setRgt($rgt)
    {
        $this->rgt = $rgt;

        return $this;
    }

    /**
     * Get rgt
     *
     * @return integer 
     */
    public function getRgt()
    {
        return $this->rgt;
    }

    /**
     * Set root
     *
     * @param integer $root
     * @return Blog
     */
    public function setRoot($root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * Get root
     *
     * @return integer 
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Set lvl
     *
     * @param integer $lvl
     * @return Blog
     */
    public function setLvl($lvl)
    {
        $this->lvl = $lvl;

        return $this;
    }

    /**
     * Get lvl
     *
     * @return integer 
     */
    public function getLvl()
    {
        return $this->lvl;
    }

    /**
     * Set createdAt
     *
     * timestampable
     */
    public function setCreatedAt() {}

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
     * timestampable
     */
    public function setUpdatedAt() {}

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
     * Add children
     *
     * @param \Anar\EngineBundle\Entity\Blog $children
     * @return Blog
     */
    public function addChild(Blog $children)
    {
        $this->children[] = $children;
        $children->setParent($this);

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Anar\EngineBundle\Entity\Blog $children
     */
    public function removeChild(Blog $children)
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
     * Add translations
     *
     * @param BlogTranslation $translation
     * @return Blog
     */
    public function addTranslation(BlogTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }

        return $this;
    }

    /**
     * Remove translations
     *
     * @param \Anar\EngineBundle\Entity\BlogTranslation $translations
     */
    public function removeTranslation(BlogTranslation $translations)
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
     * Set parent
     *
     * @param \Anar\EngineBundle\Entity\Blog $parent
     * @return Blog
     */
    public function setParent(Blog $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Anar\EngineBundle\Entity\Blog 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add apps
     *
     * @param \Anar\EngineBundle\Entity\App $apps
     * @return Blog
     */
    public function addApp(App $apps)
    {
        $this->apps[] = $apps;

        return $this;
    }

    /**
     * Remove apps
     *
     * @param \Anar\EngineBundle\Entity\App $apps
     */
    public function removeApp(App $apps)
    {
        $this->apps->removeElement($apps);
    }

    /**
     * Get apps
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getApps()
    {
        return $this->apps;
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
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Add groups
     *
     * @param Group $groups
     * @return Blog
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
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Set theme
     *
     * @param Theme $theme
     * @return Blog
     */
    public function setTheme(Theme $theme = null)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * Get theme
     *
     * @return Theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Get the options for the factory to create the item for this node
     *
     * @return array
     * @todo route can change basis address_type parameter
     */
    public function getOptions()
    {
        return array(
            'display' => ($this->isActive() and $this->isOnTree()) ?: false,
            'route' => 'anar_home_homepage',
            'routeParameters' => array(
                'blogName' => $this->name,
            ),
        );
    }

    /**
     * @return int
     */
    public function getDriveSize()
    {
        return $this->driveSize;
    }

    /**
     * @param int $driveSize
     */
    public function setDriveSize($driveSize)
    {
        $this->driveSize = $driveSize;
    }
}
