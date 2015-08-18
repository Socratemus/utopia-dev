<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Storage\Controller\Google'           =>      'Storage\Controller\GoogleController',
        )
    ),
    
    'router' => array(
        'routes' => array(
            'storage'       => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/storage[/:controller[/:action[/:id[/:name]]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Storage\Controller',
                        'controller'    => 'Google',
                        'action'        => 'Index',
                        'id' => '[0-9]*',
                        'name' => '.*',
                    ),
                )
            )
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            //'ApplicationServiceErrorHandler' => 'Engine\Service\ApplicationErrorHandlerService',
            'GoogleDrive' => 'Storage\Service\GoogleDrive',
           
        ),
    ),
    
);