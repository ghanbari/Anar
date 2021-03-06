<?php

namespace Anar\ContentBundle\Entity;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Article
 */
class Article
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
    private $slug;

    /**
     * @var string
     */
    private $abstract;

    /**
     * @var string
     */
    private $article;

    /**
     * @var integer
     */
    private $visit = 0;

    /**
     * @var boolean
     */
    private $enabled = true;

    /**
     * @var \DateTime
     */
    private $publicationStartDate;

    /**
     * @var \DateTime
     */
    private $publicationEndDate;

    /**
     * @var string
     */
    protected $image;

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
     * @var \Anar\EngineBundle\Entity\User
     */
    private $author;

    /**
     * @var \Anar\EngineBundle\Entity\User
     */
    private $editor;

    /**
     * @var Category
     */
    private $category;

    /**
     * @var \Anar\EngineBundle\Entity\Blog
     */
    private $blog;

    /**
     * @var string
     */
    private $currentLocale;

    /**
     * @var File
     */
    protected $imageFile;

    /**
     * @var string
     */
    protected $attach;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->visit = 0;
        $this->enabled = true;
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
     *
     * @return Article
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set abstract
     *
     * @param string $abstract
     *
     * @return Article
     */
    public function setAbstract($abstract)
    {
        $this->abstract = $abstract;

        return $this;
    }

    /**
     * Get abstract
     *
     * @return string
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    /**
     * Set article
     *
     * @param string $article
     *
     * @return Article
     */
    public function setArticle($article)
    {
        $this->article = $article;

        return $this;
    }

    /**
     * Get article
     *
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set visit
     *
     * @param integer $visit
     *
     * @return Article
     */
    public function setVisit($visit)
    {
        $this->visit = $visit;

        return $this;
    }

    /**
     * increase Visit visit
     *
     * @return Article
     */
    public function increaseVisit()
    {
        $this->visit += 1;

        return $this;
    }

    /**
     * Get visit
     *
     * @return integer
     */
    public function getVisit()
    {
        return $this->visit;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Article
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set publicationStartDate
     *
     * @param \DateTime $publicationStartDate
     *
     * @return Article
     */
    public function setPublicationStartDate($publicationStartDate)
    {
        $this->publicationStartDate = $publicationStartDate;

        return $this;
    }

    /**
     * Get publicationStartDate
     *
     * @return \DateTime
     */
    public function getPublicationStartDate()
    {
        return $this->publicationStartDate;
    }

    /**
     * Set publicationEndDate
     *
     * @param \DateTime $publicationEndDate
     *
     * @return Article
     */
    public function setPublicationEndDate($publicationEndDate)
    {
        $this->publicationEndDate = $publicationEndDate;

        return $this;
    }

    /**
     * Get publicationEndDate
     *
     * @return \DateTime
     */
    public function getPublicationEndDate()
    {
        return $this->publicationEndDate;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Article
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
     *
     * @return Article
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
     * Add translation
     *
     * @param ArticleTranslation $translation
     *
     * @return Article
     */
    public function addTranslation(ArticleTranslation $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translation
     *
     * @param ArticleTranslation $translation
     */
    public function removeTranslation(ArticleTranslation $translation)
    {
        $this->translations->removeElement($translation);
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
     * Set author
     *
     * @param \Anar\EngineBundle\Entity\User $author
     *
     * @return Article
     */
    public function setAuthor(\Anar\EngineBundle\Entity\User $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Anar\EngineBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set editor
     *
     * @param \Anar\EngineBundle\Entity\User $editor
     *
     * @return Article
     */
    public function setEditor(\Anar\EngineBundle\Entity\User $editor = null)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Get editor
     *
     * @return \Anar\EngineBundle\Entity\User
     */
    public function getEditor()
    {
        return $this->editor;
    }

    /**
     * Set category
     *
     * @param Category $category
     *
     * @return Article
     */
    public function setCategory(Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set blog
     *
     * @param \Anar\EngineBundle\Entity\Blog $blog
     *
     * @return Article
     */
    public function setBlog(\Anar\EngineBundle\Entity\Blog $blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return \Anar\EngineBundle\Entity\Blog
     */
    public function getBlog()
    {
        return $this->blog;
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
     * @param File $imageFile
     */
    public function setImageFile(File $imageFile=null)
    {
        if ($imageFile) {
            $this->imageFile = $imageFile;
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Set attach
     *
     * @param string $attach
     *
     * @return Article
     */
    public function setAttach($attach)
    {
        $this->attach = $attach;

        return $this;
    }

    /**
     * Get attach
     *
     * @return string
     */
    public function getAttach()
    {
        return $this->attach;
    }
}
