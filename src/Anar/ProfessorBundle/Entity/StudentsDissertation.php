<?php

namespace Anar\ProfessorBundle\Entity;

/**
 * StudentsDissertation
 */
class StudentsDissertation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $author;

    /**
     * @var string
     */
    private $title;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $createdBy;

    /**
     * @var string
     */
    private $updatedBy;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $translations;

    /**
     * @var \Anar\EngineBundle\Entity\Grade
     */
    private $grade;

    /**
     * @var \Anar\ProfessorBundle\Entity\Profile
     */
    private $profile;

    /**
     * @var string
     */
    private $currentLocale;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set author
     *
     * @param string $author
     *
     * @return StudentsDissertation
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return StudentsDissertation
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return StudentsDissertation
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
     * @return StudentsDissertation
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
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return StudentsDissertation
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     *
     * @return StudentsDissertation
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Add translation
     *
     * @param \Anar\ProfessorBundle\Entity\StudentsDissertationTranslation $translation
     *
     * @return StudentsDissertation
     */
    public function addTranslation(\Anar\ProfessorBundle\Entity\StudentsDissertationTranslation $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translation
     *
     * @param \Anar\ProfessorBundle\Entity\StudentsDissertationTranslation $translation
     */
    public function removeTranslation(\Anar\ProfessorBundle\Entity\StudentsDissertationTranslation $translation)
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
     * Set grade
     *
     * @param \Anar\EngineBundle\Entity\Grade $grade
     *
     * @return StudentsDissertation
     */
    public function setGrade(\Anar\EngineBundle\Entity\Grade $grade = null)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return \Anar\EngineBundle\Entity\Grade
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set profile
     *
     * @param \Anar\ProfessorBundle\Entity\Profile $profile
     *
     * @return StudentsDissertation
     */
    public function setProfile(\Anar\ProfessorBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \Anar\ProfessorBundle\Entity\Profile
     */
    public function getProfile()
    {
        return $this->profile;
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
}

