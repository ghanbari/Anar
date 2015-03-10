<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as UserBase;

/**
 * Admin
 */
class Admin extends UserBase
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
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
}
