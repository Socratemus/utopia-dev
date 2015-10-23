<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Geoname\Controller\Index'           =>      'Geoname\Controller\IndexController',
        )
    ),
    
    'router' => array(
        'routes' => array(
            'api'       => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/geoname[/:controller[/:action[/:id[/:name]]]]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Geoname\Controller',
                        'controller'    => 'Index',
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
            'GeonameManager' => 'Geoname\Service\GeonameManager',
        ),
        // 'factories' => array(
        //     'GeonameManager' => 'Geoname\Service\Factory'    
        // )
    ),
    
    'doctrine' => array(
        'driver' => array(
            'geoname_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/Geoname/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Geoname\Entity' => 'geoname_entities',
                ),
            )
        )
    ), 
);
