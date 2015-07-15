(function(define) {
    "use strict";

    /**
     * Register the Api class with RequireJS
     */
    define([], function() {

        var Controll = function($rootScope, $log) {
            
            var _instance = {
                
                apiListeners : function () 
                {
                    var that = this;
                    
                    $rootScope.$on('BEFORE_API_GET', function(evt,args){ return that._before_api_get(evt,args); });
                    
                    $rootScope.$on('ON_SUCCESS_API_GET', function(evt,args){ return that._on_success_api_get(evt,args); });
                    
                    $rootScope.$on('ON_ERROR_API_GET', function(evt,args){ return that._on_error_api_get(evt,args); });
                    
                    $rootScope.$on('BEFORE_API_UPDATE', function(evt,args){ return that._before_api_update(evt, args) ; });
                    
                    $rootScope.$on('ON_SUCCESS_API_UPDATE', function(evt,args){ return that._on_success_api_update(evt,args) ; });
                    
                    $rootScope.$on('ON_ERROR_API_UPDATE', function(evt,args){ return  that._on_error_api_update(evt,args) ; });
                    
                    $rootScope.$on('BEFORE_API_DELETE', function(evt,args){ return that._before_api_delete( evt , args ); });
                    
                    $rootScope.$on('ON_SUCCESS_API_DELETE', function(evt,args){ return that._on_success_api_delete( evt , args ); });
                    
                    $rootScope.$on('ON_ERROR_API_DELETE', function(evt,args){ return that._on_error_api_delete( evt , args ); });
                    
                    $rootScope.$on('BEFORE_API_CREATE', function(evt,args){ return that._before_api_create( evt , args ) ; });
                    
                    $rootScope.$on('ON_SUCCESS_API_CREATE', function(evt,args){ return that._on_success_api_create( evt , args ); });
                    
                    $rootScope.$on('ON_ERROR_API_CREATE', function(evt,args){ return that._on_error_api_create( evt , args ) ; });
                },
                
                _before_api_get : function( evt , args ){
                    //console.log(args);
                    if(args.loader == true){
                        //alert('show loading mask');
                    }
                    $log.debug(' _on_before_api_get  ');
                },
                _on_success_api_get : function( evt , args ){
                    $log.debug(' _on_success_api_get_ ');
                },
                _on_error_api_get : function ( evt , args ) {
                    $log.debug(' _on_error_api_get_ ');
                },
                
                _before_api_update : function ( evt , args ) 
                {
                    
                } ,
                _on_success_api_update : function ( evt , args ) 
                {
                    
                } ,
                _on_error_api_update : function ( evt , args ) 
                {
                    
                } ,
                
                _before_api_delete : function ( evt , args ) 
                {
                    
                } ,
                _on_success_api_delete : function ( evt , args ) 
                {
                    
                },
                _on_error_api_delete : function ( evt , args ) 
                {
                    
                },
                
                
                _before_api_create : function ( evt , args ) 
                {
                    
                } ,
                _on_success_api_create : function ( evt , args ) 
                {
                    
                },
                _on_error_api_create : function ( evt , args ) 
                {
                    
                }
                
            };

            return _instance;

        };

        return ["$rootScope", "$log", Controll];

    });


}(define));