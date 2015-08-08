<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Test\Controller\Index'           =>      'Test\Controller\IndexController',
            
        )
    ),
    
    'router' => array(
        'routes' => array(
            'test-route'       => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/test[/:controller[/:action[/:id[/:name]]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Test\Controller',
                        'controller'    => 'Index',
                        'action'        => 'Index',
                        'id' => '[0-9]*',
                        'name' => '.*',
                    ),
                ),
            )
        )
    )
);