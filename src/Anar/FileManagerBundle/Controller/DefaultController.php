<?php

namespace Anar\FileManagerBundle\Controller;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\VarDumper\VarDumper;

class DefaultController extends Controller implements AdminInterface
{
    public function indexAction(Request $request)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $accessKey = hash('sha512', $this->getUser()->getUsername().'{'.$this->getUser()->getSalt().'}');
        $setting = $this->get('vbee.manager.setting');

        /** @var Session $session */
        $session = $request->getSession();
        $session->set($blog->getName().'/fileManager/accessKey', $accessKey);
        $session->set($blog->getName().'/fileManager/maxDriveSize', $setting->get('blogpanel.filemanager.maxDriveSize'));
        $session->set($blog->getName().'/fileManager/maxUploadSize', $setting->get('blogpanel.filemanager.maxUploadSize'));

        $permission = $this->getPermissions();
        $session->set($blog->getName().'/fileManager/permission', $permission);

        return $this->render('AnarFileManagerBundle:Default:index.html.twig', array('accessKey' => $accessKey));
    }

    private function getPermissions()
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $userRepository = $this->getDoctrine()->getRepository('AnarEngineBundle:User');
        $roles = $userRepository->getRolesFilterByBlog($this->getUser()->getId(), $blog->getId());
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
