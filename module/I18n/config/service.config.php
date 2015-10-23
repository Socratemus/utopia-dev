<?php

namespace I18n;

use Zend\Session\Container;

return array (
  'factories' => array (
    
    'I18n\LocaleStrategy' => function( $sm ) {
    
        $config = $sm->get('config');
    
        $instance = new LocaleStrategy($config[__NAMESPACE__]);
        
        return $instance;
    },
    
    //'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
  ),
  
  'initializers' => array (
    function($instance, $services) {
        if($instance instanceof Detector\AbstractDetector)
        {
            $config = $services->get('I18n\LocaleStrategy')->getConfig();
            $instance->setConfig($config);
        }
    }
  ),
  'invokables' => array (
    // 'I18n\Detector\Query' => 'I18n\Detector\Query',
    // 'I18n\Detector\Route' => 'I18n\Detector\Route',
    // 'I18n\Detector\Headers' => 'I18n\Detector\Headers',
  ),
  'services' => array (

  ),
);
