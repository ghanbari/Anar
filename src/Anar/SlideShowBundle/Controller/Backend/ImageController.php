<?php

namespace Anar\SlideShowBundle\Controller\Backend;

use Anar\BlogPanelBundle\Interfaces\AdminInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\SlideShowBundle\Entity\Image;
use Anar\SlideShowBundle\Form\ImageType;

/**
 * Image controller.
 *
 */
class ImageController extends Controller implements AdminInterface
{
    /**
     * Lists all Image entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $images = $em->getRepository('AnarSlideShowBundle:Image')->findAll();
        $token = $this->get('security.csrf.token_manager')->refreshToken('slide_show_delete');

        return $this->render('AnarSlideShowBundle:Backend/Image:index.html.twig', array(
            'images' => $images,
            'token' => $token,
        ));
    }

    /**
     * Displays a form to create a new Image entity.
     *
     */
    public function newAction()
    {
        $image = new Image();
        $form   = $this->createCreateForm($image);

        return $this->render('AnarSlideShowBundle:Backend/Image:new.html.twig', array(
            'image' => $image,
            'form'   => $form->createView(),
        ));
    }
    
    /**
     * Creates a new Image entity.
     *
     */
    public function createAction(Request $request)
    {
        $image = new Image();
        $form = $this->createCreateForm($image);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $blog = $this->get('anar_engine.manager.blog')->getBlog();
            $image->setBlog($blog);
            $em = $this->getDoctrine()->getManager();
            $em->persist($image);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('image.is.uploaded'));
            return $this->redirectToRoute('anar_slide_show_backend_index');
        }

        return $this->render('AnarSlideShowBundle:Backend/Image:new.html.twig', array(
            'image' => $image,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Image entity.
     *
     * @param Image $image The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Image $image)
    {
        $form = $this->createForm(new ImageType(), $image, array(
            'action' => $this->generateUrl('anar_slide_show_backend_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'upload'));

        return $form;
    }

    /**
     * Deletes a Image entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('slide_show_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $image = $em->getRepository('AnarSlideShowBundle:Image')->find($id);

            if (!$image) {
                $status = array(
                    'code' => 404,
                    'messages' => $translator->trans('image.is.not.exists')
                );
            } else {
                $em->remove($image);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('image.is.deleted')
                );
            }
        } else {
            $status = array(
                'code' => 400,
                'message' => $translator->trans('token.is.invalid')
            );
        }

        return new JsonResponse(
            array(
                'status' => $status,
                'response' => array()
            ),
            $status['code']
        );
    }
}
