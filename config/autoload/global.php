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
                    'route'    => '/:lang/p/:slug',
                    'defaults' => array(
                        'lang' => '[a-z]{2}',
                        'slug' => '.*',
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
