<?php

namespace Application\Service;

class CategoryService extends ModelService {
    
    private $_repository = 'Application\Entity\Category';
    
    public function __construct(){
        
    }
    
    /**************************************************************************/
    //All business methods for category will be stored in here.
    
    public function getRootCategories(){
        $categories = $this->getRepository()->findBy(array('ParentId' => null ));
        return $categories;
    }
    
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

    /**************************************************************************/
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository($this->_repository);
    }
}