<?php

namespace Application\Listener;

class Router extends Listener {
    
    
    public function process(\Zend\Mvc\MvcEvent $Event){
        
        $params = $Event->getParams();
       
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'ro';
        
        $Event->getViewModel()->setVariable('lang', $lang);
       
    }
    
}