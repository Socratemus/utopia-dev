(function(define) {
    "use strict";

    /**
     * Register the GoogleDriveController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var GoogleDriveController = function($scope, $log, $interval, ControllService)
        {
            $log = $log.getInstance("GoogleDriveController");
            $log.info("constructor() ");
            
            /* Check if there is any account connected */
            var requests = {
                isConnected : function(){
                    
                    console.info('Is Connected?')
                }  
            };
            
            requests.isConnected();
            
            
            $log.info("END Google Drive controller logic.");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ControllService" , GoogleDriveController];
        
    });

}(define));