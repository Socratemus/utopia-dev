<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return array(
    // ...
     'controllers' => array(
        'invokables' => array(
            'Application\Controller\Cart'           =>      'Application\Controller\CartController',
            'Application\Controller\Category'       =>      'Application\Controller\CategoryController',
            'Application\Controller\Index'          =>      'Application\Controller\IndexController',
            'Application\Controller\Intl'           =>      'Application\Controller\IntlController',
            'Application\Controller\Item'           =>      'Application\Controller\ItemController',
            'Application\Controller\Order'          =>      'Application\Controller\OrderController'
        ),
    ),
    
   'service_manager' => array(
        'invokables' => array(
            //'ApplicationServiceErrorHandler' => 'Engine\Service\ApplicationErrorHandlerService',
            'CategoryService' => 'Application\Service\CategoryService',
            'CartService' => 'Application\Service\CartService',
            'ItemService' => 'Application\Service\ItemService',
            'OrderService' => 'Application\Service\OrderService'
        ),
    ),
    
    'router' => array(
        'routes' => array(
            
           'item'       => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:lang/p/:id',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        'id' => '[0-9]*',
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Item',
                        'action'        => 'index',
                    ),
                ),
            ),
            
            'category'  => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:lang/c/:slug',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        'slug' => '.*',
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Category',
                        'action'        => 'index',
                    ),
                ),
            ),
            
            //Other Routes!
            
        )
    )   
);
