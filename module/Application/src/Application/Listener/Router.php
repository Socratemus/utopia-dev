<?php

namespace Application\Listener;

class Router extends Listener {
    
    
    public function process(\Zend\Mvc\MvcEvent $Event){
        
        
        $routeMatch = $Event->getRouteMatch();
        
        $params = $routeMatch->getParams();
        
        if(isset($params['lang']) && !empty($params['lang'])){
            $_SESSION['lang'] = $params['lang'];
        }
        
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en'; //USE DEFAULT LANGUAGE VARIABLE
        
        if(!$lang){
            throw new \Exception('Application language failed to be set');
        }
        
        $Event->getViewModel()->setVariable('lang', $lang);
        
    }
    
}