<?php


namespace Api\Controller;

use Application\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {   
        
        //$this->JsonResponse->setVariables(array('Message' => 'This is the application api interface.'));
        $this->JsonResponse->setMessage('This is the application api interface.');
        $this->JsonResponse->setSucceed(0);
        
        return $this->JsonResponse;
    }
    
    public function testAction()
    {
        exit('admin test page.');       
    }
}