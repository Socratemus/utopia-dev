<?php


namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        
        
        //exit('admin landing page.');       
    }
    
    public function testAction()
    {
        exit('admin test page.');       
    }
}