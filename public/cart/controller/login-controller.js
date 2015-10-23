app.controller('LoginCtrl', function OverviewCtrl($scope , $http, $location, $timeout, $interval) {
    
    $scope.vars = {
        loading : false,
        message : '',
        auth    : false,
        loading : true,
        user    : {
            identity     : '',
            credential : '',
        }
    };
    $scope.fns  = {
        authenticate : function(){
            
           $http({
              method: 'GET',
              url: App.BasePath + '/auth/verify'
            }).then(function successCallback(response) {
                    
                    var data = response.data;
                    if(data.Status == 1) {
                        $scope.fns.nextStep();
                    } else {
                        console.debug(data);
                        $scope.vars.loading = false;
                    }
                    
              }, function errorCallback(response) {
                   console.error(response);
              });
            
        },
        login        : function(){
            $scope.vars.message = "Validating login credidentials"
            $scope.vars.loading = true;
            var successCallback = function( Result ){
                $timeout(function(){$scope.vars.loading = false;} , 2000);    
                var data =  Result.data;
                if(data.Status == 1) {
                    //On login successs ...
                    console.debug('Login was succesfull..');
                    $scope.fns.nextStep();
                    //Redirect to address...
                    $scope.vars.message = '';
                    
                } else {
                    //On login failed   ...   
                     $scope.vars.message = "";
                     console.debug('Invalid credidential...');
                }
                
            };
            
            var failCallback = function( Result ){
                console.error('failed to login...');
            };
            
            $http.post( App.BasePath + '/auth', $scope.vars.user, {}).then(successCallback, failCallback);
        },
        nextStep     : function(){ 
            $location.path( "/address" );
        },
    };
    
    $scope.fns.authenticate();
    
    console.debug(new Date() + '::Construct::' + 'LoginCtrl');
    
});