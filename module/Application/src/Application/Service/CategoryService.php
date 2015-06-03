<?php

namespace Application\Service;

class CategoryService extends ModelService {
    
    public function __construct(){
        //echo 'constructed!';
    }
    
    public function test()
    {
        $all = $this->getEntityManager()->getRepository('Application\Entity\Category')->findAll();    
        foreach($all as $cat){
            var_dump($cat);
        }
        
    }
    /**************************************************************************/
    //All business methods for category will be stored in here.
    
    /**************************************************************************/
    
    public function getRepository()
    {
        return $this->getEntityManager()->getRepository('Application\Entity\Category');
    }
}