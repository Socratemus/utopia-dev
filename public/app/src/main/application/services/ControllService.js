(function(define) {
    "use strict";

    /**
     * Register the Api class with RequireJS
     */
    define([], function() {

        var Controll = function($rootScope, $log , $timeout , $location , $routeParams) {
            
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
                appStatuses : function(){
                    /* Initialize application global statuses. */
                    $rootScope.statuses = [
                        { Id: 200, Name: 'Active' },
                        { Id: 307, Name: 'Disabled' },
                        { Id: 107, Name: 'Pending' },
                        { Id: 500, Name: 'Removed' }
                    ];
                    
                    $rootScope.getStatus = function(Code){ 
                        
                        var ret = null;
                        angular.forEach($rootScope.statuses, function(value, key) {
                            if(parseInt(Code) == value.Id){
                                ret = value;
                            }
                        });
                        return ret;
                        
                    };
                    
                    //console.log($rootScope);  
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
                    
                },
                
                /**
                 * Shows a notification message
                 * Type : info , success, error
                 */
                notification : function( Type , Message ){
                    $rootScope.notification = true;
                    $timeout(function(){
                        $rootScope.notification = false;
                    },2000);
                } ,
                redirect : function( Path ) {
                    console.log( Path);
                    $location.path( "/" + Path );
                } , 
                getParam : function ( Id ) {
                    if($routeParams[Id] != undefined){
                        return $routeParams[Id];
                    } else {
                        return null;
                    }
                }
                
            };

            return _instance;

        };

        return ["$rootScope", "$log" , "$timeout", "$location" , "$routeParams", Controll];

    });


}(define));