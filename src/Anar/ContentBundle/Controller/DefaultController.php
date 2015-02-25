<?php

namespace Anar\ContentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AnarContentBundle:Default:index.html.twig', array('name' => $name));
    }
}
