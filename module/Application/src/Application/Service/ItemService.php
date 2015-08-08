<?php

namespace Application\Service;

/**
 * Handles the business logic of the items.
 * Extends the model service wich provides the connection
 * to the database, via DOCTRINE ORM.
 * Can access service locator and entity manager.
 */
class ItemService extends ModelService {
    
    /**************************************************************************/
    //All business methods for item will be stored in here.
    
    /**
     * Returns all items;
     */
    public function getAll(){
        return $this->getRepository()->findAll();
    }
    
    /**
     * Return item by id
     */
    public function getItemById($Id)
    {
        return $this->getRepository()->find($Id);
    }
    
    /**
     * Returns an item by its slug.
     */
    public function getBySlug($Slug)
    {
         return $this->getRepository()->findBy(array('Slug' => $Slug));
    }
    
    /**************************************************************************/
    /**
     * Returns the repository of this service.
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Item');
    }
}