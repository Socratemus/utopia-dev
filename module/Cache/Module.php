<?php


namespace Cache;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) { 
        
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
        $ttl = 60 * 60; // 1 hour time to live.
        $globalCache = array (
                'adapter' => 'filesystem',
                'options' => array(
                    'cache_dir' => __DIR__ . '/../../data/cache/',
                    'ttl' => $ttl, //30min default
                    'namespace' => 'utopia-dev', //1h default
                ),
                'plugins' => array (
                    'exception_handler' => array ('throw_exceptions' => false),
                    'serializer',
                    'clearExpiredByFactor',
                ),
            );

        $services = array (
          'factories' => array (
                'Zend\Cache\Storage\Filesystem' => function($sm) use ($globalCache){
                    $cache = \Zend\Cache\StorageFactory::factory($globalCache);
                    return $cache;
                },
            )
        );

        return $services;
    }
}