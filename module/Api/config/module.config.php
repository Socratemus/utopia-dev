<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Api\Controller\Index'           =>      'Api\Controller\IndexController',
            'Api\Controller\Category'        =>      'Api\Controller\CategoryController',    
        )
    ),
    
    'router' => array(
        'routes' => array(
            'api'       => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api[/:controller[/:action[/:id[/:name]]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Api\Controller',
                        'controller'    => 'Index',
                        'action'        => 'Index',
                        'id' => '[0-9]*',
                        'name' => '.*',
                    ),
                )
            )
        )
    )
    
);