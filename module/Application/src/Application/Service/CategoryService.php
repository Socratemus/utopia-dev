<?php

namespace Application\Service;

/**
 * Handles the business logic of the categories.
 * Extends the model service wich provides the connection
 * to the database, via DOCTRINE ORM.
 * Can access service locator and entity manager.
 */
class CategoryService extends ModelService {
    
    private $_repository = 'Application\Entity\Category';
    
    public function __construct(){
        //parent::__construct(); //Parent constructor called
    }
    
    /**************************************************************************/
    //All business methods for category will be stored in here.
    
    /**
     * Returns an array of all root categories.
     */
    public function getRootCategories(){
        $categories = $this->getRepository()->findBy(array('ParentId' => null ));
        return $categories;
    }
    
    /**
     * Returns an array containing all the children of a given category.
     */
    public function getChildren($Parent = 1 , $Depth = 999){
        
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult("Application\Entity\Category", "c");
        $rsm->addFieldResult("c", "CategoryId", "CategoryId");
        $rsm->addFieldResult("c", "Title", "Title");
        $rsm->addFieldResult("c", "Parent", "ParentId");
        $rsm->addFieldResult("c", "Slug", "Slug");
        $rsm->addFieldResult("c", "Created", "Created");
        $rsm->addFieldResult("c", "Updated", "Updated");
        $rsm->addFieldResult("c", "Status", "Status");
        $rsm->addScalarResult("depth", "depth");
        
        $query = $this->getEntityManager()->createNativeQuery("call category_hierarchy(:id_parent,:max_depth)", $rsm);
        $query->setParameter(":id_parent", $Parent);
        $query->setParameter(":max_depth", $Depth);
    
        $categories = $query->getResult();
    
        foreach($categories as &$category){
            $tmp = $category[0];
            $tmp->setDepth($category['depth']);
            $category = $tmp;
            unset($tmp);
        }
        return $categories;
        
    }
    
    /**
     * Returns category by CategoryId.
     */
    public function getById($CategoryId){
        return $this->getRepository()->find($CategoryId);
    }
    
    /**
     * Returns category by slug.
     */
    public function getBySlug($Slug){
       
        $entity =  $this->getRepository()->findBy(array('Slug' => $Slug));;
        
        return $entity;
    }

    /**************************************************************************/
    
    /**
     * Returns the repository of this service.
     */
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->_repository);
    }
}