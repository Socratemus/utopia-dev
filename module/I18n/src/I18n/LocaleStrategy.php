<?php

namespace I18n;

use Locale;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\Mvc\MvcEvent;
use Zend\View\ViewEvent;


class LocaleStrategy implements ListenerAggregateInterface {
    
    protected $lang = null;
    
    /**
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
    
    public function attach(EventManagerInterface $events)
    {
        
        $this->listeners[] = $events->attach(MvcEvent::EVENT_ROUTE,
            array ($this, 'detectLocale'), -1);

        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH_ERROR,
            array ($this, 'detectLocale'), 100);

        $this->listeners[] = $events->attach(MvcEvent::EVENT_RENDER,
            array ($this, 'updateViewModel'), 1);

        $this->listeners[] = $events->attach(MvcEvent::EVENT_FINISH,
            array ($this, 'persistLocale'), -1);
    }
    
    /**
     *
     * @param EventManagerInterface $events
     */
    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener)
        {
            if($events->detach($listener))
            {
                unset($this->listeners[$index]);
            }
        }
    }
    
    /**
     *
     * @param MvcEvent $e
     */
    public function detectLocale(MvcEvent $e)
    {
        if($this->locale)
        {
            return;
        }
        
        //Check language from route match.
        $routeMatch = $e->getRouteMatch();
        if(!$routeMatch) {
            $params = array();
        } else {
            $params = $routeMatch->getParams();    
        }
        
        $lang = isset($params['lang']) && !empty(($params['lang'])) ? $params['lang'] : NULL;
        //var_dump($this->config['supported_languages']);
        if(! in_array($lang , $this->config['supported_languages'])) {
            $lang = $this->config['default'];
        }
        $this->locale = $lang;
    }
    
    public function persistLocale(MvcEvent $e)
    {   
        //Persist locale through application
    }
    
    /**
     *
     * @param MvcEvent $e
     */
    public function updateViewModel( MvcEvent $e )
    {
        $_SESSION['lang'] = $this->locale;
        $e->getViewModel()->setVariable('lang', $this->locale);
        
    }
    

}