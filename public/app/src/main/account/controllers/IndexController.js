(function(define) {
    "use strict";

    /**
     * Register the IndexController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var IndexController = function($scope, $log, $interval, $modal ,ApiService)
        {
            var object = {
                account : {
                    Title : '',
                    Subtitle : '',
                    Founds : 0,
                    Currency : null
                },
                accounts : []
            },
                requests = {
                    resetDefaultAccount : function(){
                        setTimeout(function(){
                           $scope.ViewVars.account.Title = '';
                            $scope.ViewVars.account.Subtitle = '';
                            $scope.ViewVars.account.Founds = 0;
                            $scope.ViewVars.account.Currency = ''; 
                        },100);
                        
                    },
                    create : function(Account){
                        ApiService.create('/account/create' , Account).then( function( Result ) {
                            //console.debug( Result );
                            $scope.ViewVars.accounts.push(Result.data.Object);
                        });
                        $log.debug('create new account.');
                    },
                    update : function( Account ){
                        //$log.debug(Account);
                        
                        ApiService.create('/account/update' , Account).then( function( Result ) {
                            
                            $log.debug(Result);
                        });
                        
                    },
                    delete : function(){
                        
                    },
                    getAll : function(){
                        ApiService.get('/account').then(function(Result){
                            object.accounts = Result.data.Object;
                        });
                    },
                    
                    openModal : function( Account ){
                        var modalInstance = $modal.open({
                          animation: true,
                          templateUrl: 'myModalContent.html',
                          controller: 'AccountModalInstanceCtrl',
                          size: 'md',
                          resolve: {
                            Account: function ( ) {
                              
                              Account.Founds = parseFloat(Account.Founds);
                             
                              return Account;
                              
                            }
                          }
                        });
                    
                        modalInstance.result.then(function (account) {
                            //console.log(account);
                            var callback = function(){
                                $scope.ViewVars.accounts.push(account);
                            }
                            if(account.AccountId == undefined)
                            {
                                requests.create(account);
                            }
                            else
                            {
                                requests.update (account);
                            }
                            requests.resetDefaultAccount();
                            //
                            //$scope.selected = selectedItem;
                        }, function () {
                          $log.info('Modal dismissed at: ' + new Date());
                        });
                        
                    }
                }
            ;
            requests.getAll();
            $scope.ViewVars = object,
            $scope.ViewMethods = requests;
            
            $log.debug('Account::IndexController');
        }
        
        return ["$scope", "$log", "$interval", "$modal" , "ApiService", IndexController];
        
    });

}(define));