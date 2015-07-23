(function (define ) {
    "use strict";

    /**
     * Register the Category class with RequireJS
     */
   define([], function() {

        var Controll = function($rootScope, $log , ApiService) {
            
            var _instance = {
                
                get : function(Id) {
                    var promise = ApiService.get('/category/get',{id : Id});
                    return promise;
                },
                
                getAll : function(){
                    var promise = ApiService.get('/category/get-all',{});
                    return promise;
                },
                
                create : function( Category ){
                    var promise = ApiService.create('/category/create', Category);
                    return promise;
                },
                
                update : function( Category ){
                    var promise = ApiService.update('/category/update',Category);
                    return promise;
                },
                
                init : function(){
                    //console.log(ApiService);
                    //console.log('on init!');   
                }
                
            };

            return _instance;

        };

        return ["$rootScope", "$log", "ApiService" , Controll];

    });


}( define  ));
