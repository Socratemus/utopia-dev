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
        var ProductsController = function($scope, $log, $interval, ControllService , ApiService)
        {
            $scope.items = [
                    
            ];
            
            $scope.collection = [];
            $scope.perPage = 5;
            $scope.totalItems = 1;
            $scope.currentPage = 1;
            
            $scope.pageChanged = function(){
                $scope.items = [];
                for(var i = ($scope.currentPage - 1) * $scope.perPage ; i < ($scope.currentPage - 1) * $scope.perPage + 5 ; i++ ){
                    if($scope.collection[i] != undefined){
                        $scope.items.push($scope.collection[i]);
                    }
                }
            }
              
            var requests = {
                getAll : function(){
                    ApiService.get('/item/get-all').then(function(Result){
                        $scope.collection = Result.data.Object;
                        $scope.totalItems = $scope.collection.length;
                        var tmp =  jQuery.extend([], Result.data.Object);
                        $scope.items = tmp.splice(0,5);
                    });    
                }
            };
            requests.getAll();
            
            
            
            $log = $log.getInstance("ProductsController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ControllService" , "ApiService" , ProductsController];
        
    });

}(define));