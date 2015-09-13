(function(define) {
    "use strict";

    /**
     * Register the IndexController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var IndexController = function($scope, $log, $interval, $modal ,ApiService)
        {
            var object = {
                accounts : [
                    {
                        Name : 'Donation founds'
                    },
                    {
                        Name : 'Reinvestments January'
                    },
                    {
                        Name : 'Reinvestments February'
                    },
                    {
                        Name : 'Shop account'
                    }
                ]
            },
                requests = {
                    openModal : function(){
                        var modalInstance = $modal.open({
                          animation: true,
                          templateUrl: 'myModalContent.html',
                          controller: 'AccountModalInstanceCtrl',
                          size: 'md'
                        });
                    
                        modalInstance.result.then(function (account) {
                            console.log(account);
                            $scope.ViewVars.accounts.push(account);
                            //$scope.selected = selectedItem;
                        }, function () {
                          $log.info('Modal dismissed at: ' + new Date());
                        });
                        
                    }
                }
            ;
            $scope.ViewVars = object,
            $scope.ViewMethods = requests;
            
            $log.debug('Account::IndexController');
        }
        
        return ["$scope", "$log", "$interval", "$modal" , "ApiService", IndexController];
        
    });

}(define));