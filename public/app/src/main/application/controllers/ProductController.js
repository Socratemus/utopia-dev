(function(define) {
    "use strict";

    /**
     * Register the ProductController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var ProductController = function($scope, $log, $interval, ControllService , ApiService , $http)
        {
            $scope.product = {
                Title : "Default Title",
                Slug : "Default slug",
                Status : 200,
                Description : "Write description in here.",
                Created : new Date(),
                Updated : new Date(),
                Product : {
                    Price : 999,
                    Stock : 1
                }
            };
            $scope.description = 'test';
            var requests = {
                save : function(){
                    ApiService.create('/item/create' , $scope.product).then(function(Result){
                        if(Result.data.Status == 1){
                            ControllService.redirect('p/e/' + Result.data.Object.ItemId);
                        }
                        console.log( Result.data);
                    });
                    
                }
            };
            
            $scope.save = requests.save;
            
            $log = $log.getInstance("ProductController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ControllService" , "ApiService" , "$http", ProductController];
        
    });

}(define));