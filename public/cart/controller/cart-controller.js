app.controller('CartCtrl', function CartCtrl($scope , $route , $location , $timeout) {
    
    var CartItems = JSON.parse(App.CartItems);
    
    var steps = [
        {
            id : 1,
            slug : '/overview',
            hideNext : false,
            hideBack : true,
            validate : function(){
                
                return CartItems.length == 0 ? true : false;
            },
            next : function(){
                $location.path( "/login" );
            },
            back : function(){
                console.debug('no back function')
            }
        },
        {
            id : 2,
            slug : '/login',
            validate : function(){
                return $scope.Cart.Identity == null ? true : false;
            },
            next : function(){
                $location.path( "/address" );
            },
            back : function(){
                $location.path( "/overview" );
            }
        },
        {
            id : 3,
            slug : '/address',
            validate : function(){
                return true;
            },
            next : function(){
                //$chdScope = $scope.$$ChildScope();
                //console.debug($chdScope.AddressForm);
                //$chdScope.AddressForm
                //$scope.fns.add();
                 //$location.path( "/payment" );
            },
            back : function(){
                 $location.path( "/overview" );
            },
            hideNext : true
        },
        {
            id : 4,
            slug : '/payment',
            validate : function(){},
            hideNext : true,
            hideBack : false,
            next : function(){
                console.debug('Finish cart, and create order.')
            },
            back : function(){
                console.debug('go to payment');
                $location.path( "/address" );
            }
        }
    ];
    
    $scope.Cart = {
        identity    : null,
        Address     : null,
        Step        : null
    };
    
    $scope.BasePath = App.BasePath;
    
    $scope.fns  = {
        processRoute : function(){
            var that = this;
            if ($route.current && $route.current.regexp) {
                var currRoute = $route.current.$$route.originalPath;
                var step      = that.getStep(currRoute);
                $scope.Cart.Step = step;
            }
        },
        getStep : function( Slug ){
            var _step = null;
            angular.forEach(steps, function(step, key) {
                if(step.slug == Slug){
                    _step = step;
                }
                
            });
            console.debug(_step);
            return _step;
        }
    };
    
    $scope.fns.processRoute();
    
    $scope.$on('$routeChangeSuccess', function(next, current) { 
       $scope.fns.processRoute();
    });
    
    console.debug(new Date() + '::Construct::' + 'CartCtrl');
    
});