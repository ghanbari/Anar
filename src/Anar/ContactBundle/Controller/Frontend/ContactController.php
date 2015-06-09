<?php

namespace Anar\ContactBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Anar\ContactBundle\Entity\Contact;
use Anar\ContactBundle\Form\ContactType;

/**
 * Contact controller.
 *
 */
class ContactController extends Controller
{
    /**
     * Displays a form to create a new Contact entity.
     *
     */
    public function newAction()
    {
        $contact = new Contact();
        $form   = $this->createCreateForm($contact);
        $blogManager = $this->get('anar_engine.manager.blog');

        return $this->render($blogManager->getTheme('AnarContactBundle:Contact:new.html.twig', 'Frontend'), array(
            'contact' => $contact,
            'form'    => $form->createView(),
        ));
    }

    /**
     * Creates a new Contact entity.
     *
     */
    public function createAction(Request $request)
    {
        $blogManager = $this->get('anar_engine.manager.blog');
        $contact = new Contact();
        $contact->setBlog($blogManager->getBlog());

        $form = $this->createCreateForm($contact);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();

            $this->addFlash('info', $this->get('translator')->trans('message.was.sended'));
            return $this->redirect($this->generateUrl('anar_contact_frontend_create', array('blogName' => $blogManager->getBlog()->getName())));
        }

        return $this->render($blogManager->getTheme('AnarContactBundle:Contact:new.html.twig', 'Frontend'), array(
            'contact' => $contact,
            'form'    => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Contact entity.
     *
     * @param Contact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Contact $entity)
    {
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $form = $this->createForm(new ContactType(), $entity, array(
            'action' => $this->generateUrl('anar_contact_frontend_create', array('blogName' => $blog->getName())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'send'));

        return $form;
    }
}
