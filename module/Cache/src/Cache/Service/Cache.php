<?php

namespace Cache\Service;

use Zend\Cache\StorageFactory;
use Zend\Cache\Storage\StorageInterface;

class Cache {
    
    const CACHE_PREFIX = 'socratemius_cache_';
    
    /**
     *
     * @var string|array
     */
    private $CacheStorage;
    
    public function __construct( $Options ){
        
    }
    
    public function getCacheStorage()
    {
        return $this->CacheStorage;
    }

    public function setCacheStorage($CacheStorage)
    {
        $this->CacheStorage = $CacheStorage;
    }
    
    public function hasItem($Key)
    {
        $key = $this->getCacheKey($Key);
        $status = $this->getCache()->hasItem($key);
        unset($key);
        return $status;
    }

    public function getItem($Key)
    {
        $key = $this->getCacheKey($Key);
        $status = $this->getCache()->getItem($key);
        unset($key);
        return $status;
    }

    public function getCache($Options = null)
    {
        $config = $this->CacheStorage;

        if(is_string($config))
        {
            $cache = $this->getServiceLocator()->get($config);
        }
        elseif(is_array($config))
        {
            $cache = StorageFactory::factory($config);
        }
        else
        {
            throw new \Exception('Cache must be configured');
        }

        if( ! $cache instanceof StorageInterface)
        {
            throw new \Exception('Cache is no instance of storage interface!');
        }

        return $cache;
    }
    
    public function clearExpired()
    {
        return $this->getCache()->clearExpired();
    }
    
    public function clear()
    {
        return $this->getCache()->clearByPrefix(self::CACHE_PREFIX);
    }
}