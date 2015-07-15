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
        var ModalController = function($scope, $modalInstance, items)
        {
            $scope.items = items;
            $scope.selected = {
                item: $scope.items[0]
            };

            $scope.ok = function() {
                $modalInstance.close($scope.selected.item);
            };

            $scope.cancel = function() {
                $modalInstance.dismiss('cancel');
            };
        };

        // Register as global constructor function
        return ["$scope", "$modalInstance", "items", ModalController];

    });


}(define));