(function(define) {
    "use strict";

    /**
     * Register the AccountModalController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var ModalController = function($scope, $log, $interval, $modalInstance, Account ,ApiService)
        {
            
            var object = {
                account : Account
            },
            requests = {
                close : function(){
                    $log.info('Modal was canceled!');
                    $modalInstance.dismiss('cancel');
                },
                submit : function(){
                    $log.info('Modal was submited!');
                    $modalInstance.close($scope.ViewVars.account);
                }
            }
            ;
            
            $scope.ViewVars = object,
            $scope.ViewMethods = requests;
            
            $log.debug('Account::ModalController::Constructor');
        }
        
        return ["$scope", "$log", "$interval", "$modalInstance" , "Account" ,"ApiService", ModalController];
        
    });

}(define));