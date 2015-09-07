<?php

namespace Application\Listener;

use Zend\EventManager\ListenerAggregateInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\EventManager\EventManagerInterface;
use Zend\Mvc\MvcEvent;

class Listener implements ListenerAggregateInterface, ServiceManagerAwareInterface
{
    protected $ServiceManager;
    
    public function __construct(ServiceManager $ServiceManager)
    {
        $this->setServiceManager($ServiceManager);
    }
    
    public function attach(EventManagerInterface $Events)
    {
        ;
    }

    public function detach(EventManagerInterface $Events)
    {
        ;
    }

    public function setServiceManager(ServiceManager $ServiceManager)
    {
        $this->ServiceManager = $ServiceManager;
    }
    
}