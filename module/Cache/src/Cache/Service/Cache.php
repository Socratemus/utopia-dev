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
        //TO BE IMPLEMENTED!!
  //       $cache = StorageFactory::factory(array(
		//     'adapter' => array(
		//         'name'    => 'apc',
		//         'options' => array('ttl' => 3600),
		//     ),
		//     'plugins' => array(
		//         'exception_handler' => array('throw_exceptions' => false),
		//     ),
		// ));

		// exit('wowz');
    }
    
    
}