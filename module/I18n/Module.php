<?php

namespace I18n;

use Zend\Mvc\MvcEvent;
use I18n\View\Helper\Languages;
use Zend\Console\Request as ConsoleRequest ;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {  
        if(!$e->getRequest() instanceof ConsoleRequest)
        {
            $app = $e->getApplication();
            
            $events = $app->getEventManager();
            
            $sm = $app->getServiceManager();
            
            $strategy = $sm->get("I18n\LocaleStrategy");
            
            $strategy->attach($events);
           
            $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Application',
                'route',
                function(MvcEvent $e) {
                    if(isset($_SESSION['lang']))
                    {
                        $e->getRouter()->setDefaultParam('lang', $_SESSION['lang']);
                    } else {
                        
                        $e->getRouter()->setDefaultParam('lang', 'en');
                        
                    }
                }, 100);
           
        }
        
    }
    
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return include __DIR__ . '/config/service.config.php';
    }
}