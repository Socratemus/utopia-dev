(function(define) {
    "use strict";

    /**
     * Register the MainController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var MainController = function($scope, $log, $interval, ApiService)
        {
            var requests = {
                
            };
            
            $log = $log.getInstance("MainController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ApiService", MainController];
        
    });

}(define));