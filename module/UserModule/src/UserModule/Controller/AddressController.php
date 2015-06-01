<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace UserModule\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use UserModule\Entity;

class AddressController extends AbstractActionController {

    public function onDispatch(\Zend\Mvc\MvcEvent $e) {
        parent::onDispatch($e);
        //Verificare login
        if (!$this->zfcUserAuthentication()->hasIdentity()) {
            //get the email of the user
            return $this->redirect()->toRoute('zfcuser/login');
        }
    }


    /**
     * User Address listing
     */
    public function indexAction() 
    {
        //$userService = $this->getServiceLocator()->get('AddressService');
        $user = $this->zfcUserAuthentication()->getIdentity();
        $userAddresses = $user->getUserAddresses();
        $vm = new ViewModel();
        $vm->setVariable('addresses', $userAddresses);
        return $vm;
    }
    
    public function editAction()
    {
        $request = $this->getRequest();
        $addressId = $this->params()->fromRoute('id');
        /*@var $addressService \UserModule\Service\AddressService*/
        $addressService = $this->getServiceLocator()->get('AddressService');
        $userAddress = $addressService->getUserAddressById($addressId);
        
        $form = $addressService->getUserAddressForm($userAddress);
        if($request->isPost())
        {
            $post = $this->getRequest()->getPost()->toArray();
            $form->setData($post);
            if($form->isValid())
            {
                $addressService->saveUserAddress($userAddress);
                $this->redirect()->toRoute('user-addresses');
            }
        }
        $vm = new ViewModel();
        $vm->setVariable('form', $form);
        return $vm;
    }
    
    public function addAction()
    {
        /*@var $addressService \UserModule\Service\AddressService*/
        $addressService = $this->getServiceLocator()->get('AddressService');
        $userAddress = new Entity\UserAddress();
        $form = $addressService->getUserAddressForm($userAddress);
        
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $post = $this->getRequest()->getPost()->toArray();
            $form->setData($post);
            if($form->isValid())
            {
                $addressService->saveUserAddress($userAddress);
                $this->redirect()->toRoute('user-addresses');
            }
        }
        
        $vm = new ViewModel();
        $vm->setVariable('form', $form);
        return $vm;
    }
    
    public function removeAction()
    {
        $request = $this->getRequest();
        $addressId = $this->params()->fromRoute('id');
        /*@var $addressService \UserModule\Service\AddressService*/
        $addressService = $this->getServiceLocator()->get('AddressService');
        
        $addressService->removeUserAddress($addressId);
        
        $this->redirect()->toRoute('user-addresses');
    }
}