<?php

namespace Anar\EngineBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\GroupInterface;
use FOS\UserBundle\Model\User as BaseUser;

class User extends BaseUser
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    private $fname;

    /**
     * @var string
     */
    private $lname;

    /**
     * @var string
     */
    private $faname;

    /**
     * @var integer
     */
    private $staffCode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $groups;

    /**
     * @var \Anar\EngineBundle\Entity\Grade
     */
    private $grade;

    /**
     * constructor
     */
    public function __construct()
    {
        parent::__construct();
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
     * Set fname
     *
     * @param string $fname
     * @return User
     */
    public function setFname($fname)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname
     *
     * @return string 
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname
     *
     * @param string $lname
     * @return User
     */
    public function setLname($lname)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get lname
     *
     * @return string 
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set faname
     *
     * @param string $faname
     * @return User
     */
    public function setFaname($faname)
    {
        $this->faname = $faname;

        return $this;
    }

    /**
     * Get faname
     *
     * @return string 
     */
    public function getFaname()
    {
        return $this->faname;
    }

    /**
     * Set staffCode
     *
     * @param integer $staffCode
     * @return User
     */
    public function setStaffCode($staffCode)
    {
        $this->staffCode = $staffCode;

        return $this;
    }

    /**
     * Get staffCode
     *
     * @return integer 
     */
    public function getStaffCode()
    {
        return $this->staffCode;
    }

    /**
     * Add groups
     *
     * @param Group|GroupInterface $groups
     * @return User
     */
    public function addGroup(GroupInterface $groups)
    {
        if (!$this->groups->contains($groups)) {
            $this->groups[] = $groups;
        }

        return $this;
    }

    /**
     * Remove groups
     *
     * @param Group|GroupInterface $group
     * @return null
     */
    public function removeGroup(GroupInterface $group)
    {
        $this->groups->removeElement($group);
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
     * User no have any roles
     *
     * User have groups & groups have roles
     *
     * @param string $role
     * @return void
     */
    public function addRole($role) {}

    /**
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles) {}

    /**
     * User no have any roles
     *
     * User have groups & groups have roles
     *
     * @param string $role
     * @return void
     */
    public function removeRole($role) {}

    /**
     * @param string|Role $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return parent::hasRole($role);
        } else {
            return in_array($role, $this->getRoles(), true);
        }
    }

    /**
     * Set grade
     *
     * @param Grade $grade
     * @return User
     */
    public function setGrade(Grade $grade = null)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return Grade
     */
    public function getGrade()
    {
        return $this->grade;
    }
}
