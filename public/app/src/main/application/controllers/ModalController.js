/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function(define) {
    "use strict";

    /**
     * Register the MainController class with RequireJS
     */
    define([], function( )
    {
        var ModalController = function($scope, $modal, $log)
        {
            $scope.items = ['item1', 'item2', 'item3'];

            $scope.animationsEnabled = true;

            $scope.open = function(size) {

                var modalInstance = $modal.open({
                    animation: $scope.animationsEnabled,
                    templateUrl: 'myModalContent.html',
                    controller: 'ModalInstanceCtrl',
                    size: size,
                    resolve: {
                        items: function() {
                            return $scope.items;
                        }
                    }
                });

                modalInstance.result.then(function(selectedItem) {
                    $scope.selected = selectedItem;
                }, function() {
                    $log.info('Modal dismissed at: ' + new Date());
                });
            };

            $scope.toggleAnimation = function() {
                $scope.animationsEnabled = !$scope.animationsEnabled;
            };
        };

        // Register as global constructor function
        return ["$scope", "$modal", "$log", ModalController];

    });


}(define));