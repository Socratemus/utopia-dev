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
    // 'bjyauthorize' => array(
    //     'guards' => array(
    //         'BjyAuthorize\Guard\Controller' => array(
    //             array('controller' => 'Cli\Controller\Index', 'roles' => array('guest')),
    //         ),
    //     ),
    // ),
    'service_manager' => array(
        'invokables' => array(
            //'ApplicationServiceErrorHandler' => 'Engine\Service\ApplicationErrorHandlerService',
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
                )
            )
        )
    )    
);