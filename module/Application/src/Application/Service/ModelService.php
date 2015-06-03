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
    
}