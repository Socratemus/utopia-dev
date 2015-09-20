<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\View\ViewEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        //Set default timezone
        
        date_default_timezone_set('Europe/Bucharest');
        
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $sm = $e->getApplication()->getServiceManager();
        $config = $sm->get('config');
        $eventManager->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function($e) use ($sm) {
            $controller = $e->getTarget();
            $controllerClass = get_class($controller);
            $moduleNamespace = substr($controllerClass, 0, strpos($controllerClass, '\\'));
            $config = $e->getApplication()->getServiceManager()->get('config');
            if (isset($config['module_layouts'][$moduleNamespace])) {
                $controller->layout($config['module_layouts'][$moduleNamespace]); //Apply layout.
            }
            
            $cartsrv = $sm->get('CartService');
            $cartsrv->verify();
            
        }, 100);
        
        if(array_key_exists('app_listeners', $config))
        {   
            $applistners = $config['app_listeners'];
           
            foreach ($applistners as $subject => $cfg)
            {
                
                foreach ($cfg['events'] as $event => $listeners)
                {
                  foreach ($listeners as $lClass => $lCfg)
                    {
                        if(is_array($lCfg))
                        {
                            if(array_key_exists('callback', $lCfg))
                            {
                                $callback = $lCfg['callback'];
                            }
                            if(array_key_exists('priority', $lCfg))
                            {
                                $priority = intval($lCfg['priority']);
                            }
                        }
                        try
                        {
                            if($sm->has($lClass))
                            {
                                $listener = $sm->get($lClass);
                            }
                            elseif(class_exists($lClass))
                            {
                                $newClass = new \ReflectionClass($lClass);
                                if($newClass->implementsInterface('Zend\ServiceManager\ServiceManagerAwareInterface'))
                                {
                                    $listener = new $lClass($sm);
                                }
                                else
                                {
                                    $listener = new $lClass();
                                }
                                unset($newClass);
                            }
                            else
                            {
                                continue;
                            }
                           
                            
                            if(isset($listener) && !empty($listener))
                            {
                                $eventManager->getSharedManager()->attach($subject, $event, array ($listener, $callback), $priority);
                            }
                        }
                        catch(\Exception $err)
                        {
                            continue;
                        }
                    }
                        
                }//Foreach event listned to
                //$eventManager->getSharedManager()->attach($subject, $event, array ($listener, $callback), $priority);
            } //Foreach subject
        }
        
        $eventManager->getSharedManager()->attach('Zend\View\View', ViewEvent::EVENT_RENDERER_POST, function($event) {

            $renderer = $event->getRenderer();
            $translator = $renderer->plugin('translate');
            $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en'; // SET TO DEFAULT LANG
            $translator->getTranslator()->setLocale($lang);
           
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
