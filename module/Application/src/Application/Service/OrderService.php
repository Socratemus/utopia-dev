<?php

namespace Application\Service;

class OrderService extends ModelService {
    
    public function __construct(){
        //echo 'constructed!';
    }
    
    /**************************************************************************/
    //All business methods for order will be stored in here.
    
    /**
     * Returns paged orders
     */
    public function getPaged(){
        
    }
    
    /**
     * Adds a new order
     */
    public function addOrder(){
        
    }
    
    /**
     * 
     * 
     */
    public function cancelOrder(){
        
    }
    
    
    
    /**************************************************************************/
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Order');
    }
}