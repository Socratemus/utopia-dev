(function(define) {
    "use strict";

    /**
     * Register the AccountOverviewController class with RequireJS
     * Displays the records from an account
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var AccountOverviewController = function($scope, $log, $interval, $modal ,ApiService)
        {
            var object = {
                records : [
                    {
                        
                    },
                    {
                        
                    },
                    {
                        
                    },
                    {
                        
                    }
                ]
            },
                requests = {
                    
                    openModal : function(){
                        $log.info('Toggle modal.');
                        
                    }
                }
            ;
            
            $scope.ViewVars = object,
            $scope.ViewMethods = requests;
            
            $log.debug('Account::AccountOverviewController');
        }
        
        return ["$scope", "$log", "$interval", "$modal" , "ApiService", AccountOverviewController];
        
    });

}(define));