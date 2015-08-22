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
        var ProductController = function($scope, $log, $interval, $timeout, ControllService , ApiService , $http)
        {
            /******************************************************************/
            /* Initializing variables */
            var itemId = ControllService.getParam('id');
            var requests = {
                item                : {
                    /**
                     * Fetches an item from server
                     * by its given Id
                     */
                    get             : function( Id ) 
                    {
                        ApiService.get('/item/get' , {id : Id}).then(function(Result){
                            Result.data.Object.Created = new Date(Result.data.Object.Created);
                            Result.data.Object.Updated = new Date(Result.data.Object.Updated);
                            
                            $scope.item = Result.data.Object;    
                            $scope.item.Product.Producer = 1;
                            angular.forEach( $scope.item.Product.Galery, function(Item, key) {
                                Item.src = Item.Small;
                            });
                            requests.filter.get();
                            if($scope.item.Categories.length > 0){
                                requests.filter.chCurrCat($scope.item.Categories[0]);
  
                            } else {
                                requests.filter.chCurrCat(null);
                            }
                        });
                    },
                    /**
                     * Creates a new item
                     */
                    create          : function( )
                    {
                        var item = $scope.item;
                        ApiService.create('/item/create' , item).then(function(Result){
                            if(Result.data.Status == 1){
                                ControllService.notification(1);
                                ControllService.redirect('p/e/' + Result.data.Object.ItemId);
                            }
                        });
                        
                    },
                    /**
                     * Update the current item.
                     */
                    update          : function()
                    {
                        var item = $scope.item;
                        ApiService.update('/item/update' , item).then(function(Result){
                            if(Result.data.Status != 1){
                                ControllService.notification(2);
                                setTimeout(function(){window.location.reload()},1500)
                            }
                            $scope.item.Cover = Result.data.Object.Cover;
                            $scope.item.Product.Galery = Result.data.Object.Product.Galery;
                            angular.forEach( $scope.item.Product.Galery, function(Item, key) {
                                Item.src = Item.Small;
                            });
                            ControllService.notification(1);
                        });
                    },
                    /**
                     * Removes a category image
                     */
                    remGalImg       : function( Elem , Index )
                    {
                        if(Elem.ImageId !== undefined){
                            ApiService.delete('/item/remove-galery-image' , {params: {ProductId : $scope.item.Product.ProductId,ImageId: Elem.ImageId}}).then(function(Result){
                                ControllService.notification(2);
                            });
                        }
    
                        $scope.item.Product.Galery.splice(Index, 1);
                    }
                },
                category            : {
                    /**
                     * Fetches all categories from server
                     */
                    getAll   : function()
                    {
                        ApiService.get('/category/get-all',{}).then(function(Result){
                            $scope.categories = Result.data.Object;
                        });
                    },
                    /**
                     * Returns a category by its id
                     */
                    get     : function( Id )
                    {
                        var found = null;
                        angular.forEach( $scope.categories, function(Item, key) {
                                if(Item.CategoryId == Id){
                                    found = Item
                                }
                        });
                        if(!found){return null}
                        return found;
                    },
                },
                filter              : {
                    /**
                     * Fetches all filters for all product 
                     * categories.
                     */
                    get             : function()
                    {
                        $scope.item.filters = {};
                        angular.forEach( $scope.item.Categories, function(CategoryId, key) {
                            ApiService.get('/category/get-filters' , {c : CategoryId}).then(function(Result){
                                $scope.item.filters[CategoryId] = Result.data.Object;
                            });  
                        });
                    },
                    /**
                     * Changes the current displayed category
                     * in the filter sidebar.
                     */
                    chCurrCat       : function( Id )
                    {
                        //console.info('Current filters category : ' + Id );
                        $scope.item.filtersCat = Id;
                    },
                    /**
                     * Adds a new filter. 
                     */
                    add             : function()
                    {
                        //console.log($scope.item.filtersCat);
                        if( !$scope.item.filtersCat)  {
                            console.log('!!there is no category selected!!');
                            return;
                        }
                        
                        var Object = {
                            Title : 'Default',
                            Slug : 'default ',
                            Category : $scope.item.filtersCat,
                            FilterValues : []
                        };
                        Object.FilterValues[$scope.item.ItemId] = {
                            Value : 'Default', Slug : 'Default' , ItemId : $scope.item.ItemId
                        };
                        $scope.item.filters[$scope.item.filtersCat].push(Object);
                    },
                    /**
                     * Settup ItemId on every filter value
                     * there is
                     */
                    setupFilterValues: function(){
                        
                        var filters = $scope.item.filters;
                        angular.forEach( filters, function( Category , key) {
                            angular.forEach( Category, function( Filter , key) {
                                angular.forEach( Filter.FilterValues, function( FilterValue , key) {
                                    if(FilterValue.ItemId != $scope.item.ItemId){
                                        //remove all filter values that are not of this item,
                                        delete Filter.FilterValues[FilterValue.ItemId];
                                    }
                                });
                                if(Filter.FilterValues[$scope.item.ItemId] == undefined){
                                    Filter.FilterValues[$scope.item.ItemId] = {
                                        ItemId : $scope.item.ItemId,
                                        Value  : 'empty',
                                        Slug  : 'empty'
                                    };
                                } else {
                                     Filter.FilterValues[$scope.item.ItemId].ItemId =  $scope.item.ItemId;
                                }
                            });
                        });
                       
                    },
                    /**
                     * Saves an existing filter. 
                     */
                    save            : function( Filter )
                    {
                        //se face save filter.
                        Filter.isLoading = true;
                       
                        var filterval = Filter.FilterValues[$scope.item.ItemId];
                        if(Filter.FilterId != undefined)
                        {
                            ApiService.update('/category/update-filter' , Filter).then(function(Result){
                                Filter.isLoading = false;
                                var retFv = Result.data.Object.FilterValues[$scope.item.ItemId];
                                filterval.FilterValueId = retFv.FilterValueId;
                            });
                        }
                        else
                        {
                            
                            //Se face create
                            Filter.Category = $scope.item.filtersCat;
                            ApiService.create('/category/create-filter' , Filter).then(function(Result){
                                Filter.isLoading = false;
                                Filter.FilterId = Result.data.Object.FilterId;
                                var retFv = Result.data.Object.FilterValues[$scope.item.ItemId];
                                filterval.FilterValueId = retFv.FilterValueId;
                            });
                            
                        }
                    },
                    /**
                     * Removes a filter.
                     */
                    delete          : function( Filter , Index )
                    {
                        //First removez it from $scope.item.filters[currCategory]
                        Filter.isLoading = true;
                        var filters = $scope.item.filters;
                        var currCat = $scope.item.filtersCat;
                        if(Filter.FilterId) {
                            //Send server request
                            var params = {
                                params : {
                                    id : Filter.FilterId
                                }
                            };
                            ApiService.delete('/category/delete-filter' , params).then(function( Result ){
                                //Can send notification.
                            });
                        }
                        $timeout(function(){
                            filters[currCat].splice(Index, 1);    
                        },1000);
                        
                        
                    }
                },
            };
            /******************************************************************/
            /* Bind variables to controller scope */
            $scope.item = {
                Title : "Default Title ---",
                Slug : "Default slug",
                Status : 200,
                Description : "Write description in here.",
                Categories  : [],
                Created : new Date(),
                Updated : new Date(),
                Product : {
                    Price : 999,
                    Stock : 1,
                    Producer : 1
                }
            };
            $scope.categories = [];
            $scope.actions = {
                item        : requests.item,
                category    : requests.category,
                filter      : requests.filter
            };
            /******************************************************************/
            /* LOGIC OF THE CONTROLLER */
            if(itemId){
                requests.item.get(itemId);
            }
            requests.category.getAll();
            /******************************************************************/
            /* Watch methdos. */
            $scope.$watch( 'item',
                    function( Nv, Ov ) {

                        if(Nv.Categories == undefined || Ov.Categories == undefined)  return;
                        /* category changed variable */
                        var ctch = Nv.Categories.length != Ov.Categories.length;
                        if(ctch){
                            if(Nv.Categories[0] == "") {Nv.Categories = [];}
                            requests.filter.get();
                        }
                        
                        // if(Nv.Categories.length > 0 ) 
                        // { requests.filter.chCurrCat(Nv.Categories[0]); } 
                        // else 
                        // { requests.filter.chCurrCat(null); }
                        
                        if(Nv.Categories.length > 0 ) 
                        {} 
                        else 
                        {}
                        
                        if(Nv.filters != undefined){
                            requests.filter.setupFilterValues();
                        }
                        
                    }, true
            );
            $log = $log.getInstance("ProductController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "$timeout", "ControllService" , "ApiService" , "$http", ProductController];
        
    });

}(define));