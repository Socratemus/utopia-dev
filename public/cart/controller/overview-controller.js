app.controller('OverviewCtrl', function OverviewCtrl($scope, $route) {
    
    var cartItems = JSON.parse(App.CartItems);
    
    var cart      = JSON.parse(App.Cart);
    
    $scope.vars = {
        cartItems : cartItems,
        cart      : cart,
    };
    
    $scope.fns  = {
        
    };
    
    console.debug(new Date() + '::Construct::' + 'OverviewCtrl');
});