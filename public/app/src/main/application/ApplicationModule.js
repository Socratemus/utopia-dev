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
            
            
            'application/controllers/MainController',
            'application/controllers/CategoryController',
            
            'application/controllers/ModalController',
            'application/controllers/ModalInstanceController'
        ],
        function ( 
            $log,
            SessionService, ApiService, ControllService,
    
            /* ReservationStatuses, */
        
            MainController, CategoryController,  ModalController , ModalInstanceCtrl)
        {
           
            //$log.debug('Start loading application module');
            var moduleName = "main.Application";
           
            angular.module( moduleName, [ ] )
                .service(       "session"              ,    SessionService      )
                .service(       "ApiService"           ,    ApiService          )
                .service(       "ControllService"      ,    ControllService     )
               
                /*.directive(     "reservationStatuses"  ,    ReservationStatuses )*/
                
                .controller(    "MainCtrl"             ,    MainController      )
                .controller(    "CategoryCtrl"         ,    CategoryController  )
                
                .controller(    "ModalCtrl"            ,    ModalController     )
                .controller(    "ModalInstanceCtrl"    ,    ModalInstanceCtrl   )
           
            $log.info('APPLICATION MODULE LOADED');
            
            return moduleName;
        });

}( define, angular ));

