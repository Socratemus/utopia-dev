<?php

return array(
    'router' => array(
        'routes' => array(
        // HTTP routes are here
            'cli'       => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/cli[/:controller[/:action]]',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        'slug' => '.*',
                        '__NAMESPACE__' => 'Cli\Controller',
                        'controller'    => 'Cli\Controller\Index',
                        'action'        => 'index',
                    ),
                ),
            ),
        )
    ),
    'controllers' => array(
        'invokables' => array(
            'Cli\Controller\Index' => 'Cli\Controller\IndexController',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'ProcessManager' => 'Cli\Service\ProcessManager',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                /**
                 * Cli Routes are accessed by going into /public and then run
                 *  php index.php sync-process
                 * 
                **/
                'sync-items' => array(
                    'options' => array(
                        'route'    => 'sync-process [<id>]',
                        'defaults' => array(
                            'controller' => 'Cli\Controller\Index',
                            'action'     => 'index'
                        )
                    )
                ),

                'run-command' => array (
                    'options' => array (
                        'route' => 'run command [--verbose|-v] <class> <method> <cacheKey> <key>',
                        'defaults' => array (
                            'controller' => 'Cli\Controller\Index',
                            'action' => 'run',
                        )
                    )
                )
            )
        )
    ),

    'doctrine' => array(
        'driver' => array(
            'cli_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/Cli/Entity',
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Cli\Entity' => 'cli_entities',
                ),
            )
        )
    ),    
);