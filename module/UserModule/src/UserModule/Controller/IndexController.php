<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UserModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        parent::onDispatch($e);
        if (!$this->zfcUserAuthentication()->hasIdentity())
        {
            //get the email of the user
            return $this->redirect()->toRoute('zfcuser/login');
        }
    }

    public function indexAction()
    {
        $user = $this->zfcUserAuthentication()->getIdentity();
        $userService = $this->getServiceLocator()->get('UserService');
        $userForm = $userService->getUserForm($user);
        
        $validator = new \Zend\Validator\EmailAddress();
        $validator->setOptions(array('domain' => FALSE));
        
        $userForm->getInputFilter()->get('roles')->setAllowEmpty(true);
        $userForm->getInputFilter()->get('email')->getValidatorChain()->addValidator($validator);
        $errors = array();
        if ($this->getRequest()->isPost())
        {
            $post = $this->getRequest()->getPost()->toArray();
            if($post['email'] == $user->getEmail())
            {
                $newValidatorChain = new \Zend\Validator\ValidatorChain;
                foreach($userForm->getInputFilter()->get('email')->getValidatorChain()->getValidators() as $validator)
                {
                    if (!($validator['instance'] instanceof \DoctrineModule\Validator\UniqueObject)) 
                    {
                        $newValidatorChain->addValidator($validator['instance'], $validator['breakChainOnFailure']);
                    }
                }
                $userForm->getInputFilter()->get('email')->setValidatorChain($newValidatorChain);
            }
            $userForm->setData($post);
            try
            {
                if ($userForm->isValid())
                {
                    $userService->saveUser($user);
                } 
                else
                {
                    $errors = $userForm->getMessages();
                }
            }
            catch (\Exception $e)
            {
                $errors['email'][] = "This email address is already in use.";
            }
        }


        $viewModel = new ViewModel();
        $viewModel->setVariables(array(
            'errors' => $errors,
            'userForm' => $userForm
        ));

        return $viewModel;
    }

    public function ordersAction()
    {
        
    }

    public function settingsAction()
    {
        
    }

    public function addressesAction()
    {
        
    }

}
