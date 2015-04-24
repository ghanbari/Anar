<?php

namespace Anar\ProfessorBundle\Entity;
use Anar\EngineBundle\Entity\Translation;

/**
 * StudentsDissertationTranslation
 */
class StudentsDissertationTranslation extends Translation
{
    /**
     * @var integer
     */
    protected $id;

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
     * @var \Anar\ProfessorBundle\Entity\StudentsDissertation
     */
    protected $object;

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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return StudentsDissertationTranslation
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
     * @return StudentsDissertationTranslation
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
     * @return StudentsDissertationTranslation
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
     * @return StudentsDissertationTranslation
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
     * Set object
     *
     * @param \Anar\ProfessorBundle\Entity\StudentsDissertation $object
     *
     * @return StudentsDissertationTranslation
     */
    public function setObject($object = null)
    {
        $this->object = $object;

        return $this;
    }

    /**
     * Get object
     *
     * @return \Anar\ProfessorBundle\Entity\StudentsDissertation
     */
    public function getObject()
    {
        return $this->object;
    }
}

