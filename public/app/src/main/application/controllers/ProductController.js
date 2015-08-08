(function(define) {
    "use strict";

    /**
     * Register the ProductController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var ProductController = function($scope, $log, $interval, ControllService , ApiService , $http)
        {
            var itemId = ControllService.getParam('id');
            
            var requests = {
                save : function( Exists ){
                    if(Exists == true) {
                        return requests.saveExisting()
                    }
                    
                    ApiService.create('/item/create' , $scope.product).then(function(Result){
                        if(Result.data.Status == 1){
                            ControllService.notification(1);
                            ControllService.redirect('p/e/' + Result.data.Object.ItemId);
                        }
                        
                    });
                },
                saveExisting  : function(){
                    ApiService.update('/item/update' , $scope.product).then(function(Result){
                        if(Result.data.Status != 1){
                            ControllService.notification(2);
                            setTimeout(function(){window.location.reload()},1500)
                        }
                        $scope.product.Cover = Result.data.Object.Cover;
                        $scope.product.Product.Galery = Result.data.Object.Product.Galery;
                        angular.forEach( $scope.product.Product.Galery, function(Item, key) {
                            Item.src = Item.Small;
                        });
                        ControllService.notification(1);
                    });
                    
                } ,
                getItem : function(Id){
                    
                    ApiService.get('/item/get' , {id : Id}).then(function(Result){
                        Result.data.Object.Created = new Date(Result.data.Object.Created);
                        Result.data.Object.Updated = new Date(Result.data.Object.Updated);
                        $scope.product = Result.data.Object;    
                        $scope.product.Product.Producer = 1;
                        angular.forEach( $scope.product.Product.Galery, function(Item, key) {
                            Item.src = Item.Small;
                        });
                    });
                    
                },
                getCategories : function(){
                    ApiService.get('/category/get-all',{}).then(function(Result){
                        //console.log(Result.data.Object);
                        $scope.categories = Result.data.Object;
                    });
                },
                removeGaleryImage : function(Elem , Index){
                    if(Elem.ImageId !== undefined){
                        ApiService.delete('/item/remove-galery-image' , {params: {ProductId : $scope.product.Product.ProductId,ImageId: Elem.ImageId}}).then(function(Result){
                            ControllService.notification(2);
                        });
                    }

                    $scope.product.Product.Galery.splice(Index, 1);
                },
                showCat : function(CatId){
                    var found = null;
                    angular.forEach( $scope.categories, function(Item, key) {
                            if(Item.CategoryId == CatId){
                                found = Item.Title
                            }
                    });
                    if(!found){return null}
                    return found.replace(/\_/g, '');
                }
            };
            
            
            $scope.product = {
                Title : "Default Title",
                Slug : "Default slug",
                Status : 200,
                Description : "Write description in here.",
                Created : new Date(),
                Updated : new Date(),
                Product : {
                    Price : 999,
                    Stock : 1
                }
            };
            $scope.save = requests.save;
            $scope.showCat = requests.showCat;
            $scope.removeGaleryImage = requests.removeGaleryImage; 
            
            if(itemId){
                requests.getItem(itemId);
            }
            requests.getCategories();
            
            $log = $log.getInstance("ProductController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ControllService" , "ApiService" , "$http", ProductController];
        
    });

}(define));