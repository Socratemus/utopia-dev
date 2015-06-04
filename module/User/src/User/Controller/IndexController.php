<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{

    public function onDispatch(\Zend\Mvc\MvcEvent $e)
    {
        // parent::onDispatch($e);
        // if (!$this->zfcUserAuthentication()->hasIdentity())
        // {
        //     //get the email of the user
        //     return $this->redirect()->toRoute('zfcuser/login');
        // }
    }

    /*
     * User account page.
     */
    public function indexAction()
    {
        
    }

    /*
     * User orders page.
     */
    public function ordersAction()
    {
        
    }

}
