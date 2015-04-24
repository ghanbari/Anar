<?php

namespace Anar\EngineBundle\Entity;

/**
 * Log
 */
class Log
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var string
     */
    private $createdBy;

    /**
     * @var array
     */
    private $routeParams;

    /**
     * @var array
     */
    private $postParams;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $entity;

    /**
     * @var string
     */
    private $event;

    /**
     * @var Blog
     */
    private $blog;

    /**
     * @var string
     */
    private $message;

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
     * @return Log
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
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return Log
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
     * Set routeParams
     *
     * @param array $routeParams
     *
     * @return Log
     */
    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;

        return $this;
    }

    /**
     * Get routeParams
     *
     * @return array
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * Set postParams
     *
     * @param array $postParams
     *
     * @return Log
     */
    public function setPostParams($postParams)
    {
        $this->postParams = $postParams;

        return $this;
    }

    /**
     * Get postParams
     *
     * @return array
     */
    public function getPostParams()
    {
        return $this->postParams;
    }

    /**
     * Set ip
     *
     * @param string $ip
     *
     * @return Log
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set entity
     *
     * @param string $entity
     *
     * @return Log
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;

        return $this;
    }

    /**
     * Get entity
     *
     * @return string
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Set event
     *
     * @param string $event
     *
     * @return Log
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set blog
     *
     * @param null|Blog $blog
     *
     * @return Log
     */
    public function setBlog($blog = null)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return null|Blog
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Log
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }
}
