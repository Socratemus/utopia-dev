<?php

namespace Log;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        
        $eventManager->attach('dispatch.error', function($event) {
            $exception = $event->getResult()->exception;
            if (isset($exception) && !empty($exception)) {
                $sm = $event->getApplication()->getServiceManager();
                $service = $sm->get('Log\Factory\LogFactory');
                
                $extra = array();
                if(isset($_SERVER['REQUEST_URI']))
                {
                    $extra = array (
                      'url' => $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                      'ipaddress' => $_SERVER['REMOTE_ADDR'],
                    );
                }
                else
                {
                    $extra = array (
                       'url' => $_SERVER['PHP_SELF'],
                       'ipaddress' => '127.0.0.1',
                       //'username' => 'ProcessManager',
                    );
                }
                
                $service->getLogger()->crit($exception , $extra);
            }
        });
       
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

}
