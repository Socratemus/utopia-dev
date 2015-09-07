<?php

namespace Application\Listener;

class Router extends Listener {
    
    
    public function process(\Zend\Mvc\MvcEvent $Event){
        //echo 'doing'; 
        $params = $Event->getParams();
        //$Event->setParam('lang' , 'ro'); //NOT WORKING
       
    }
    
}