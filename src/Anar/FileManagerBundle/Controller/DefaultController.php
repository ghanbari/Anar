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
        $fileManager = $this->get('anar_file_manager');
        return $this->render('AnarFileManagerBundle:Default:index.html.twig', array('accessKey' => $fileManager->getAccessKey()));
    }
}
