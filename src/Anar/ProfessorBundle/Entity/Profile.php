<?php

namespace Anar\ProfessorBundle\Entity;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Profile
 */
class Profile
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $birthday;

    /**
     * @var string
     */
    private $website;

    /**
     * @var string
     */
    private $avatar;

    /**
     * @var string
     */
    private $bio;

    /**
     * @var \DateTime
     */
    private $jobStartedAt;

    /**
     * @var string
     */
    private $skill;

    /**
     * @var string
     */
    private $favorite;

    /**
     * @var string
     */
    private $article;

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
     * @var \Anar\EngineBundle\Entity\Blog
     */
    private $blog;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $studentsDissertation;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $translations;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $plans;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $educations;

    /**
     * @var string
     */
    private $currentLocale;

    /**
     * @var File
     */
    private $avatarFile;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->studentsDissertation = new \Doctrine\Common\Collections\ArrayCollection();
        $this->translations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->educations = new \Doctrine\Common\Collections\ArrayCollection();
        $this->plans = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Profile
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Profile
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set birthday
     *
     * @param integer $birthday
     *
     * @return Profile
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return integer
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set website
     *
     * @param string $website
     *
     * @return Profile
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return Profile
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set bio
     *
     * @param string $bio
     *
     * @return Profile
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set jobStartedAt
     *
     * @param \DateTime $jobStartedAt
     *
     * @return Profile
     */
    public function setJobStartedAt($jobStartedAt)
    {
        $this->jobStartedAt = $jobStartedAt;

        return $this;
    }

    /**
     * Get jobStartedAt
     *
     * @return \DateTime
     */
    public function getJobStartedAt()
    {
        return $this->jobStartedAt;
    }

    /**
     * Set skill
     *
     * @param string $skill
     *
     * @return Profile
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;

        return $this;
    }

    /**
     * Get skill
     *
     * @return string
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * Set favorite
     *
     * @param string $favorite
     *
     * @return Profile
     */
    public function setFavorite($favorite)
    {
        $this->favorite = $favorite;

        return $this;
    }

    /**
     * Get favorite
     *
     * @return string
     */
    public function getFavorite()
    {
        return $this->favorite;
    }

    /**
     * Set article
     *
     * @param string $article
     *
     * @return Profile
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * @return Profile
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
     * Set blog
     *
     * @param \Anar\EngineBundle\Entity\Blog $blog
     *
     * @return Profile
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
     * Add studentsDissertation
     *
     * @param \Anar\ProfessorBundle\Entity\StudentsDissertation $studentsDissertation
     *
     * @return Profile
     */
    public function addStudentsDissertation(\Anar\ProfessorBundle\Entity\StudentsDissertation $studentsDissertation)
    {
        $this->studentsDissertation[] = $studentsDissertation;

        return $this;
    }

    /**
     * Remove studentsDissertation
     *
     * @param \Anar\ProfessorBundle\Entity\StudentsDissertation $studentsDissertation
     */
    public function removeStudentsDissertation(\Anar\ProfessorBundle\Entity\StudentsDissertation $studentsDissertation)
    {
        $this->studentsDissertation->removeElement($studentsDissertation);
    }

    /**
     * Get studentsDissertation
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStudentsDissertation()
    {
        return $this->studentsDissertation;
    }

    /**
     * Add translation
     *
     * @param \Anar\ProfessorBundle\Entity\ProfileTranslation $translation
     *
     * @return Profile
     */
    public function addTranslation(\Anar\ProfessorBundle\Entity\ProfileTranslation $translation)
    {
        $this->translations[] = $translation;

        return $this;
    }

    /**
     * Remove translation
     *
     * @param \Anar\ProfessorBundle\Entity\ProfileTranslation $translation
     */
    public function removeTranslation(\Anar\ProfessorBundle\Entity\ProfileTranslation $translation)
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
     * @return \Symfony\Component\HttpFoundation\File\File
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }

    /**
     * @param File|null $avatarFile
     */
    public function setAvatarFile(File $avatarFile=null)
    {
        if ($avatarFile) {
            $this->avatarFile = $avatarFile;
            $this->updatedAt = new \DateTime();
        }
    }

    /**
     * Add plan
     *
     * @param \Anar\ProfessorBundle\Entity\Plan $plan
     *
     * @return Profile
     */
    public function addPlan(Plan $plan)
    {
        $this->plans[] = $plan;

        return $this;
    }

    /**
     * Remove plan
     *
     * @param \Anar\ProfessorBundle\Entity\Plan $plan
     */
    public function removePlan(Plan $plan)
    {
        $this->plans->removeElement($plan);
    }

    /**
     * Get plans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlans()
    {
        return $this->plans;
    }

    /**
     * Add education
     *
     * @param \Anar\ProfessorBundle\Entity\Education $education
     *
     * @return Profile
     */
    public function addEducation(Education $education)
    {
        $this->educations[] = $education;
        $education->setProfile($this);

        return $this;
    }

    /**
     * Remove education
     *
     * @param \Anar\ProfessorBundle\Entity\Education $education
     */
    public function removeEducation(Education $education)
    {
        $this->educations->removeElement($education);
    }

    /**
     * Get educations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEducations()
    {
        return $this->educations;
    }
}
