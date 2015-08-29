<?php

namespace Anar\FileManagerBundle\EventListener;

use Anar\EngineBundle\Doctrine\BlogManager;
use Anar\EngineBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use VBee\SettingBundle\Manager\SettingDoctrineManager;
use Doctrine\Bundle\DoctrineBundle\Registry;

class FileManager
{
    /**
     * @var BlogManager
     */
    private $blogManager;

    /**
     * @var SettingDoctrineManager
     */
    private $setting;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @param BlogManager $blogManager
     * @param SettingDoctrineManager $setting
     * @param Session $session
     * @param TokenStorage $tokenStorage
     * @param Registry $doctrine
     */
    public function __construct($blogManager, $setting, $session, $tokenStorage, $doctrine)
    {
        if (!$tokenStorage->getToken()->isAuthenticated()) {
            throw new AuthenticationException();
        }

        $this->blogManager = $blogManager;
        $this->setting = $setting;
        $this->session = $session;
        $this->user = $tokenStorage->getToken()->getUser();
        $this->doctrine = $doctrine;
    }

    public function getAccessKey()
    {
        $blog = $this->blogManager->getBlog();
        $accessKey = hash('sha512', $this->user->getUsername());
        $privateKey = hash('sha512', $blog->getName());

        $permission = $this->getPermissions();

        $this->session->set($blog->getName().'/fileManager/permission', $permission);
        $this->session->set($blog->getName().'/fileManager/accessKey', $accessKey.'{'.$privateKey.'}');
        $this->session->set($blog->getName().'/fileManager/maxDriveSize', $blog->getDriveSize());
        $this->session->set($blog->getName().'/fileManager/maxUploadSize', $this->setting->get('blogpanel.filemanager.maxUploadSize'));

        return $accessKey;
    }

    private function getPermissions()
    {
        $blog = $this->blogManager->getBlog();
        $userRepository = $this->doctrine->getRepository('AnarEngineBundle:User');
        $roles = $userRepository->getRolesFilterByBlog($this->user->getId(), $blog->getId());
        $permissions = array(
            'delete_files' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__DELETE_FILES', $roles))?: false,
            'create_folders' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__CREATE_FOLDERS', $roles))?: false,
            'delete_folders' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__DELETE_FOLDERS', $roles))?: false,
            'upload_files' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__UPLOAD_FILES', $roles))?: false,
            'rename_files' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__RENAME_FILES', $roles))?: false,
            'rename_folders' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__RENAME_FOLDERS', $roles))?: false,
            'duplicate_files' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__DUPLICATE_FILES', $roles))?: false,
            'copy_cut_files' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__COPY_FILES', $roles))?: false,
            'copy_cut_dirs' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__COPY_FOLDERS', $roles))?: false,
            'chmod_files' => false,
            'chmod_dirs' => false,
            'preview_text_files' => true,
            'create_text_files' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__CREATE_TXT', $roles))?: false,
            'edit_text_files' => (in_array('ROLE_ADMIN', $roles) or in_array('ANAR_FILEMANAGER__EDIT_TXT', $roles))?: false,
        );

        return $permissions;
    }
}