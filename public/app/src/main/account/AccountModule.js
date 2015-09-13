/**
 * ******************************************************************************************************
 *
 *   AccountModule
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
            'account/controllers/IndexController',
            'account/controllers/AccountModalController',
        ],
        function (  $log ,
            IndexController , AccountModalController
        
        ){
            
            var moduleName = "main.Account";
            
            angular.module( moduleName, [ ] )
                 .controller(    "IndexCtrl"                ,    IndexController               )
                 .controller(    "AccountModalInstanceCtrl" ,    AccountModalController        )
                
            ;
            
            $log.info('ACCOUNT MODULE LOADED');
            
            return moduleName;
        });
        
}( define, angular ));