(function(define) {
    "use strict";

    /**
     * Register the CategoriesController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var CategoriesController = function($scope, $log, $interval, ControllService,  CategoryService)
        {
            $scope.categories = [
                { CategoryId : 1, Title : 'Test title' , Slug : 'test-title' , Status : '200' , Created : '01.01.2015' , Updated : '' },
                { CategoryId : 2, Title : 'Test title' , Slug : 'test-title' , Status : '200' , Created : '01.01.2015' , Updated : '' },
                { CategoryId : 3, Title : 'Test title' , Slug : 'test-title' , Status : '200' , Created : '01.01.2015' , Updated : '' },
                { CategoryId : 4, Title : 'Test title' , Slug : 'test-title' , Status : '200' , Created : '01.01.2015' , Updated : '' },
                { CategoryId : 5, Title : 'Test title' , Slug : 'test-title' , Status : '200' , Created : '01.01.2015' , Updated : '' }
            ];
            var requests = {
                getAll : function(){
                    CategoryService.getAll().then(function( Result ){
                        console.log(Result); 
                        if(Result.data.Status == 1){
                            var categories = Result.data.Object;
                            $scope.categories = categories;
                        }
                    });
                }
            };
            requests.getAll();
            $log = $log.getInstance("CategoriesController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ControllService" , "CategoryService", CategoriesController];
        
    });

}(define));