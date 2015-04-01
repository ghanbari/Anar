<?php

namespace Anar\SuperPanelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SettingController extends Controller
{
    /**
     *
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $form = $this->createPasswordEditForm();
        return $this->render('AnarSuperPanelBundle:Setting:index.html.twig', array('form' => $form->createView()));
    }

    /**
     * @return \Symfony\Component\Form\Form
     */
    private function createPasswordEditForm()
    {
        return $this->createFormBuilder(null, array(
            'action' => $this->generateUrl('anar_super_panel_setting_update_password'),
            'method' => 'POST',
            'translation_domain' => 'forms',
            'invalid_message' => 'password.is.not.identical',
            ))->add('oldPassword', 'password', array(
                'translation_domain' => 'forms',
                'label' => 'password.old',
                'required' => true,
            ))
            ->add('password', 'repeated', array(
                'type' => 'password',
                'first_name' => 'first',
                'first_options' => array(
                    'label' => 'password.new',
                ),
                'second_name' => 'second',
                'second_options' => array(
                    'label' => 'password.repeat',
                )
            ))->add('submit', 'submit', array(
                'label' => 'update'
            ))
            ->getForm();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function passwordUpdateAction(Request $request)
    {
        $translator = $this->get('translator');
        $userManager = $this->get('fos_user.user_manager');
        $user = $this->getUser();
        $form = $this->createPasswordEditForm();

        $form->handleRequest($request);
        $password = $form->getData();

        $encoder_service = $this->get('security.encoder_factory');
        $encoder = $encoder_service->getEncoder($user);
        $encoded_pass = $encoder->encodePassword($password['oldPassword'], $user->getSalt());

        if ($encoded_pass == $user->getPassword()) {
            if (isset($password['password'])) {
                $user->setPlainPassword($password['password']);
                $userManager->updatePassword($user);
                $userManager->updateUser($user);
                $status = array(
                    'code' => 200,
                    'message' => $translator->trans('information.was.updated'),
                );
            } else {
                $status = array(
                    'code' => 400,
                    'message' => $translator->trans('password.is.not.identical'),
                );
            }
        } else {
            $status = array(
                'code' => 403,
                'message' => $translator->trans('password.is.wrong'),
            );
        }

        return new JsonResponse(array(
            'status' => $status,
            'response' => array(),
        ));
    }
}