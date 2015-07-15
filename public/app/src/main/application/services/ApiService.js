(function(define) {
    "use strict";

    /**
     * Register the Api class with RequireJS
     */
    define([], function() {

        var Api = function($rootScope, $log, $http, Api) {
            var _service = {
                
                _basePath: APP_PATH,
                
                get: function( UriPath , Params , Loader )
                {
                    var that = this;
                    var url = this._basePath + UriPath;
                   
                    if( Loader == undefined) {
                        Loader = true;
                    }
                    
                    $rootScope.$broadcast('BEFORE_API_GET', {loader : Loader});
                    
                    var promise = $http({
                        url: url,
                        method: "GET",
                        params: Params
                    });

                    promise.success(function(data, status, headers, config) {
                        $rootScope.$broadcast('ON_SUCCESS_API_GET',  {data : data , status : status, headers : headers, config : config });
                    });
                    
                    promise.error(function(data, status, headers, config) {
                        $rootScope.$broadcast('ON_ERROR_API_GET' , {data : data , status : status, headers : headers, config : config });
                    });

                    return promise;
                },
                
                delete: function( UriPath , Params , Loader )
                {
                    var that = this;
                    var url = this._basePath + UriPath;
                    
                    if( Loader == undefined) {
                        Loader = true;
                    }
                    
                    $rootScope.$broadcast('BEFORE_API_DELETE', {loader : Loader});
                    
                    var promise = $http.delete(url, Params);
                    
                    promise.success(function(data, status, headers, config){
                        $rootScope.$broadcast('ON_SUCCESS_API_DELETE');
                    });
                    
                    promise.error(function(data, status, headers, config) {
                        $rootScope.$broadcast('ON_ERROR_API_DELETE');
                    });
                    
                    return promise;
                },
                
                update: function( UriPath , Params , Config , Loader)
                {
                    var that = this;
                    var url = this._basePath + UriPath;
                    
                    if( Loader == undefined) {
                        Loader = true;
                    }
                    
                    $rootScope.$broadcast('BEFORE_API_UPDATE', {loader : Loader});
                    
                    var promise = $http.post(url, Params , Config);
                    
                    promise.success(function(data, status, headers, config){
                        $rootScope.$broadcast('ON_SUCCESS_API_UPDATE');
                    });
                    
                    promise.error(function(data, status, headers, config) {
                        $rootScope.$broadcast('ON_ERROR_API_UPDATE');
                    });
                    
                    return promise;
                },
                
                create: function( UriPath , Params, Config , Loader )
                {
                    var that = this;
                    var url = this._basePath + UriPath;
                    
                    if( Loader == undefined) {
                        Loader = true;
                    }
                    
                    $rootScope.$broadcast('BEFORE_API_CREATE', {loader : Loader});
                    
                    var promise = $http.put(url, Params, Config);
                    
                    promise.success(function(data, status, headers, config){
                        
                        $rootScope.$broadcast('ON_SUCCESS_API_CREATE');
                    });
                    
                    promise.error(function(data, status, headers, config) {
                        
                        $rootScope.$broadcast('ON_ERROR_API_CREATE');
                    });
                    
                    return promise;
                }

            };

            return _service;

        };

        return ["$rootScope", "$log", "$http", Api];

    });


}(define));