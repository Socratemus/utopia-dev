app.controller('PaymentCtrl', function PaymentCtrl($scope , $location) {
    
    $scope.vars = {
       
    };
    $scope.fns  = {
        create : function(){
            //!!Apply identity and address to order!!
            //console.debug($scope.Cart); 
            window.location = App.BasePath + '/en/o/create';
        }
    };
    
    console.debug(new Date() + '::Construct::' + 'PaymentCtrl');
    
});