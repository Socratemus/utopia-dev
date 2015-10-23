app.controller('AddressCtrl', function OverviewCtrl($scope , $location) {
    
    $scope.vars = {
        address : {
            contact     : 'cornelius iancu',
            email       : 'corneliu.iancu29@gmail.com',
            phone       : '0724508044',
            postalCode  : 32789,
            address     : 'Com Brazi Sat Brazii de sus, Jud Prahova, Str. Zambilelor, Nr 43'
        },
        addresses : [{} , {} ]
    };
    $scope.fns  = {
        add : function( Form ){
            if(! Form.$valid) {
                $scope.Cart.Address = null;
                console.debug('form is not valid.')
                return;
            };
            
            
            var address = $scope.vars.address;
            $scope.Cart.Address = address;
            $scope.Cart.Step.next();
            
        },
        nextStep : function(){
            $location.path( "/payment" );
        }
    };
    
    console.debug($scope);
    
    $scope.$watch('AddressForm.$valid', function(n , o){
        $scope.Cart.Address = null;
        console.debug('Form old validation : ' + o);
        console.debug('Form new validation : ' + n);
        if( false === n ) {
            $scope.Cart.Address = null;
        }
        
    },true);
    
    console.debug(new Date() + '::Construct::' + 'AddressCtrl');
    
});