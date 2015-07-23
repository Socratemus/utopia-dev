/**
 * ******************************************************************************************************
 *
 *   ApplicationModule
 *
 *   Defines controllers and services for the Trip Admin
 *
 *  @author     Corneliu Iancu
 *  @date       May 2015
 *
 * *****************************************************************************
 */

(function ( define, angular ) {
    "use strict";

    define([
            'utils/logger/ExternalLogger',
            'application/services/SessionService',
            'application/services/ApiService',
            'application/services/ControllService',
            'application/services/CategoryService',
            
            
            'application/controllers/MainController',
            'application/controllers/CategoryController', 'application/controllers/CategoriesController',
            'application/controllers/ProductsController',
            
            'application/controllers/ModalController',
            'application/controllers/ModalInstanceController'
        ],
        function ( 
            $log,
            SessionService, ApiService, ControllService, CategoryService,
    
            /* ReservationStatuses, */
        
            MainController, CategoryController, CategoriesController , ProductsController,
            ModalController , ModalInstanceCtrl)
        {
           
            //$log.debug('Start loading application module');
            var moduleName = "main.Application";
           
            angular.module( moduleName, [ ] )
                .service(       "session"              ,    SessionService      )
                .service(       "ApiService"           ,    ApiService          )
                .service(       "ControllService"      ,    ControllService     )
                .service(       "CategoryService"      ,    CategoryService     )
                
               
                /*.directive(     "reservationStatuses"  ,    ReservationStatuses )*/
                
                .controller(    "MainCtrl"             ,    MainController      )
                .controller(    "CategoryCtrl"         ,    CategoryController  )
                .controller(    "CategoriesCtrl"       ,    CategoriesController)
                .controller(    "ProductsCtrl"         ,    ProductsController)
                
                .controller(    "ModalCtrl"            ,    ModalController     )
                .controller(    "ModalInstanceCtrl"    ,    ModalInstanceCtrl   )
           
            $log.info('APPLICATION MODULE LOADED');
            
            return moduleName;
        });

}( define, angular ));

