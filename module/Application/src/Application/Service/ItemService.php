<?php

namespace Application\Service;

class ItemService extends ModelService {
    
    public function __construct(){
        //echo 'constructed!';
    }
    
    /**************************************************************************/
    //All business methods for item will be stored in here.
    
    /**
     * Returns all items;
     */
    public function getAll(){
        return $this->getRepository()->findAll();
        
        return array();
    }
    
    /**
     * Return item by id
     */
    public function getItemById($Id)
    {
        
    }
    
    /**
     * 
     */
    public function getItemBySlug($Slug)
    {
        
    }
    
    /**************************************************************************/
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Item');
    }
}