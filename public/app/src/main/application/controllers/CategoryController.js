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
        var CategoryController = function($scope, $log, $interval, ControllService, ApiService , CategoryService)
        {
            $scope.dt = new Date();
            $scope.dta = new Date();
            $scope.status = { Name : 'Active'};
            $scope.opened = false;$scope.openeda = false;
            $scope.open = function($event) {
                $event.preventDefault();
                $event.stopPropagation();
                $scope.opened = true;
            };
            $scope.dateOptions ={
                "class" : "custom-dpk"
            };
            $scope.category = {
                Title : '',
                Slug  : '',
                Status : "998"
            }
            var requests = {
                getCategory : function(Id) {
                    CategoryService.get(Id).then(function(Result){
                        console.log(Result);
                        $scope.category = Result.data.Object;
                    });
                },
                getAll : function(){
                    CategoryService.getAll().then(function( Result ){
                        console.log(Result); 
                        if(Result.data.Status == 1){
                            var categories = Result.data.Object;
                            $scope.categories = categories;
                        }
                    });
                },
                save : function(){
                    //console.log($scope.category);
                    CategoryService.update($scope.category).then(function(Result){
                        ControllService.notification('success' , 'Successfully saved.');
                        console.log(Result);
                    });
                    //console.log('save category');
                },
                init : function(){
                    
                    CategoryService.init();
                },
                slugify : function(Input){
                    var value = Input;
                    return value.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                }
            };
            
            $scope.save = function( Mode ){
                
                if($scope.category._parent){
                    $scope.category.ParentId = $scope.category._parent.CategoryId;
                }
                
                if(Mode == 'save'){
                    return requests.save();
                }
                
                CategoryService.create($scope.category).then(function( Result ){
                    console.log(Result);
                    if(Result.data.Status == 1) {
                        //setTimeout(function(){
                            ControllService.redirect('c/e/' + Result.data.Object.CategoryId);
                        //},3000)
                        ControllService.notification('success' , 'Successfully added.');
                    }
                    
                });
                
            };
            $scope.slugify = function(){
                $scope.category.Slug = requests.slugify($scope.category.Title)
            };
            requests.init();
            requests.getAll();
            
            var categoryId = ControllService.getParam('id');
            
            if(categoryId) {
                requests.getCategory(categoryId);
                //console.log('load category...' + categoryId);
            } 
            
            $log = $log.getInstance("CategoryController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ControllService", "ApiService" , "CategoryService", CategoryController];
        
    });

}(define));