<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace User\Controller;

use Application\Controller\AbstractActionController as AbstractActionController;
use Zend\View\Model\ViewModel;


class AuthController extends AbstractActionController
{
    /**
     * Authentification methods via XhrRequests
     */
    public function indexAction(){
        
        $request = $this->getRequest();
        
        if(!$request->isPost()){
            $this->JsonResponse->setMessage('Invalid request');
            
            $this->JsonResponse->setFailed();
            
            return   $this->JsonResponse;
        }
        
        $data = $this->getPayload();
     
        $this->getRequest()->getPost()->set('identity', $data['identity']);
        
        $this->getRequest()->getPost()->set('credential', $data['credential']);
        
        $this->zfcUserAuthentication()->getAuthAdapter()->resetAdapters();
        
        $this->zfcUserAuthentication()->getAuthService()->clearIdentity();
        
        $adapter = $this->zfcUserAuthentication()->getAuthAdapter();
        
        $adapter->prepareForAuthentication($this->getRequest());
        
        $auth = $this->zfcUserAuthentication()->getAuthService()->authenticate($adapter);
        
        if (!$auth->isValid()) {
            
            $adapter->resetAdapters();
        
            $this->JsonResponse->setFailed();
        }
        else
        {
           
            $this->JsonResponse->setSucceed();
            
        }
        
        $this->JsonResponse->setVariables(array(
            'post' => $data    
        ));
        
        $this->JsonResponse->setMessage(__METHOD__);
        
        return $this->JsonResponse;
    }
    
    /**
     * Checks user auth status.
     * Response status 1 => auth
     * Response status 2 => auth faild to validate.
     */
    public function verifyAction(){
        try
        {
            sleep(2);
            $authService = $this->zfcUserAuthentication()->getAuthService();
            if( $authService->hasIdentity() ){
                $user = $authService->getIdentity();
                $this->JsonResponse->setMessage(__METHOD__);
                $this->JsonResponse->setVariables(
                    array(
                        'user' => $user->toArray()
                    )    
                );
            }  else {
                    $this->JsonResponse->setFailed();
                    $this->JsonResponse->setMessage('Auth verify failed.');
            }
            
            return $this->JsonResponse;
            
        }
        catch(\Exception $e)
        {
            $this->getLogger()->crit($e);
            $this->JsonResponse->setFailed();
            return $this->JsonResponse;
        }
    }
}