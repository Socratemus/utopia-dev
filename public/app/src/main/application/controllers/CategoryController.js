(function(define) {
    "use strict";

    /**
     * Register the CategoryController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var CategoryController = function($scope, $log, $interval, ApiService)
        {
            var requests = {
                
            };
            
            $log = $log.getInstance("CategoryController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ApiService", CategoryController];
        
    });

}(define));