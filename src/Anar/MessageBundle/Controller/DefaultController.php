<?php

namespace Anar\MessageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AnarMessageBundle:Default:index.html.twig', array('name' => $name));
    }
}
