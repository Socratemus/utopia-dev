<?php

namespace Application\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ModelService implements ServiceLocatorAwareInterface 
{
    
    protected $ServiceLocator;
    protected $EntityManager;
    
    public function setServiceLocator(ServiceLocatorInterface $ServiceLocator)
    {
        $this->ServiceLocator = $ServiceLocator;
        $this->EntityManager = $this->ServiceLocator->get('entitymanager');
    }
    
    public function getServiceLocator()
    {
        return $this->ServiceLocator;    
    }
    
    protected function getEntityManager()
    {
        return $this->EntityManager;
    }
    
    protected function getBaseUri(){
        $request = $this->getServiceLocator()->get('Request');
        $uri = $request->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $base = sprintf('%s://%s', $scheme, $host);
        return $base;
    }
}