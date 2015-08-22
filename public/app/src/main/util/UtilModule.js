/**
 * ******************************************************************************************************
 *
 *   UtilModule
 *
 *   Defines miscelanous controllers and services for the Trip Admin
 *
 *  @author     Corneliu Iancu
 *  @date       August 2015
 *
 * *****************************************************************************
 */

(function ( define, angular ) {
    "use strict";

    define([
            'utils/logger/ExternalLogger',
            'util/services/DomService',
            'util/services/DecoratorService',

            //'application/controllers/MainController',
          
        ],
        function ( 
            $log, 
            DomService , DecoratorService
            )
        {
            
            $log.debug('Start loading util module');
            var moduleName = "main.Util";
           
            angular.module( moduleName, [ ] )
                .service(       "DomService"              ,    DomService        )
                .service(       "DecoratorService"        ,    DecoratorService  )
            ;
           
            $log.info('UTIL MODULE LOADED');
            
            return moduleName;
        });

}( define, angular ));

