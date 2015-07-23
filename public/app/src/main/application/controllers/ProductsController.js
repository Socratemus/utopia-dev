(function(define) {
    "use strict";

    /**
     * Register the ProductsController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var ProductsController = function($scope, $log, $interval, ControllService)
        {
           
            var requests = {
                getAll : function(){
                    
                }
            };
            requests.getAll();
            $log = $log.getInstance("ProductsController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ControllService" , ProductsController];
        
    });

}(define));