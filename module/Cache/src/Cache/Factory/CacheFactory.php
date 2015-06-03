<?php

namespace Cache\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Cache\Service\Cache as Cache;

class CacheFactory implements FactoryInterface
{
    private $config;

    private $ServiceLocator;

    public function createService(ServiceLocatorInterface $ServiceLocator)
    {
        $service = new Cache(array());
        
        $config = $ServiceLocator->get('config');
        
        //extract cache settings
        if( ! isset($config['cache']) || empty($config['cache']) )
        {
            throw new \Exception('Cache settings not set!');
        }
        
        $cacheSettings = $config['cache'];
        
        $service->setCacheStorage($cacheSettings);
        
        return $service ;
        
        //return $servicelocator->get('Your\Service');
    }   
}
