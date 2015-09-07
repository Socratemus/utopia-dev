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
            /* Application module */
            
            'Application\Controller\Cart'           =>      'Application\Controller\CartController',
            'Application\Controller\Category'       =>      'Application\Controller\CategoryController',
            'Application\Controller\Index'          =>      'Application\Controller\IndexController',
            'Application\Controller\Intl'           =>      'Application\Controller\IntlController',
            'Application\Controller\Item'           =>      'Application\Controller\ItemController',
            'Application\Controller\Order'          =>      'Application\Controller\OrderController',
            
            /* Admin module */
            'Admin\Controller\Index'          =>      'Admin\Controller\IndexController'
        ),
    ),
    
   'service_manager' => array(
        'invokables' => array(
            //'ApplicationServiceErrorHandler' => 'Engine\Service\ApplicationErrorHandlerService',
            'CategoryService' => 'Application\Service\CategoryService',
            'CartService' => 'Application\Service\CartService',
            'ItemService' => 'Application\Service\ItemService',
            'OrderService' => 'Application\Service\OrderService',
            'ImageService' => 'Application\Service\ImageService'
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'admin'       => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/:controller[/:action]]',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
            ),
            
           'item'       => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:lang/p/:slug',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        'slug' => '.*',
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Application\Controller\Item',
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
            
            
            'flight' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/:lang/flight[/:controller[/:action[/:id[/:name]]]]',
                    'constraints' => array(
                        'lang' => '[a-z]{2}',
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]*',
                        'name' => '.*',
                    ),
                    'defaults' => array(
                         //'lang' => 'ro',
                        'controller' => 'flightSearch',
                        'action' => 'index',
                    ),
                ),
            ),
            
            'order'     => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:lang/o[/:action[/:slug]]',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        'slug' => '.*',
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Order',
                        'action'        => 'index',
                    ),
                ),    
            ),
            
            'cart'      => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:lang/cart[/:action]',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        'slug' => '.*',
                        '__NAMESPACE__' => 'Application\Controller',
                        'controller'    => 'Cart',
                        'action'        => 'index',
                    ),
                ),  
            ),
            
            'user'      => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/:lang/account',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        'slug' => '.*',
                        '__NAMESPACE__' => 'User\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),    
            ),
            
            //Other Routes!
            
        )
    )   
);
