<?php

namespace Application\Listener;

class Menu extends Listener {
    
    
    public function process(\Zend\Mvc\MvcEvent $Event){
        
        $sm = $this->getServiceManager();
        
        $categoryService = $sm->get('CategoryService');
        $categories = $categoryService->getRootCategories();
        
        $params = $Event->getParams();
        
        $Event->getViewModel()->setVariable('categories', $categories);
       
    }
    
}