<?php

namespace Anar\SlideShowBundle\Controller\Frontend;

use Anar\EngineBundle\Interfaces\ApplicationInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Image controller.
 *
 */
class ImageController extends Controller implements ApplicationInterface
{
    public function showAction()
    {
        $blogManager = $this->get('anar_engine.manager.blog');
        $imageRepo = $this->getDoctrine()->getRepository('AnarSlideShowBundle:Image');
        $images = $imageRepo->findByBlog($blogManager->getBlog());

        return $this->render($blogManager->getTheme('AnarSlideShowBundle:Image:show.html.twig', 'Frontend'), array('images' => $images));
    }
}
