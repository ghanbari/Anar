<?php

namespace Anar\ContactBundle\Controller\Backend;

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
     * Lists all Contact entities.
     *
     */
    public function indexAction($page)
    {
        $doctrine = $this->getDoctrine();
        $blog = $this->get('anar_engine.manager.blog')->getBlog();
        $count = $this->get('vbee.manager.setting')->get('blogpanel.item_per_page');
        $query = $doctrine->getRepository('AnarContactBundle:Contact')->getAllFilterByBlogQueryBuilder($blog);
        $contacts = $this->get('knp_paginator')->paginate($query, $page, $count);

        $token = $this->get('security.csrf.token_manager')->refreshToken('contact_delete');

        return $this->render('AnarContactBundle:Backend:index.html.twig', array(
            'contacts' => $contacts,
            'token' => $token,
        ));
    }


    /**
     * Deletes a Contact contact.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $translator = $this->get('translator');

        if ($this->isCsrfTokenValid('contact_delete', $request->request->get('token'))) {
            $em = $this->getDoctrine()->getManager();
            $contact = $em->getRepository('AnarContentBundle:Contact')->find($id);

            if (!$contact) {
                $status = array(
                    'code' => 404,
                    'messages' => $translator->trans('contact.is.not.exists')
                );
            } else {
                $em->remove($contact);
                $em->flush();
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('contact.is.deleted')
                );
            }
        } else {
            $status = array(
                'code' => 400,
                'message' => $translator->trans('token.is.invalid')
            );
        }

        return (new JsonResponse(array(
            'status' => $status,
            'response' => array()
        )))->setStatusCode($status['code']);
    }
}
