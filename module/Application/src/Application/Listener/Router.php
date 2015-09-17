<?php

namespace Application\Listener;

class Router extends Listener {
    
    
    public function process(\Zend\Mvc\MvcEvent $Event){
        
        $params = $Event->getParams();
       
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'ro';
        // var_dump($lang);exit;
        
        $Event->getViewModel()->setVariable('lang', $lang);
        $Event->getViewModel()->langu = 'sex';
       
        // var_dump($Event->getViewModel()->getVariables());exit;
    }
    
}