<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class OrderController extends AbstractActionController
{
    /**
     *  The page where you will see the details of an order 
     */
    public function IndexAction(){
        
        return $this->redirect('home');
        /* @TODO */
    }
    
    /**
     *  The page where an order is created! 
     */
    public function createAction(){
        /* @TODO */
    }
    
    /**
     * Confirmation page
     */
    public function confirmAction(){
        
        $guid = $this->params()->fromRoute('slug');
        
        
    }
    
    /**
     * Successfully created an order
     */
    public function congratsAction(){
        /* @TODO */
    }
    
}

?>