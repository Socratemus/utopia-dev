(function(define) {
    "use strict";

    /**
     * Register the CliController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var CliController = function($scope, $log, $interval, ApiService)
        {
            var object = {
                commands : []
            };
            
            var methods = {
                getCommands : function(){
                    ApiService.get('/cli').then(function( Result ){
                        $scope.ViewVars.commands = Result.data.Object;
                    });;
                },
                run : function(Command){
                    Command.Status = 107;
                    ApiService.update('/cli/run' , Command).then(function( Result ){
                        console.log(Result);
                          
                    });
                    //console.log(Command);
                }
            };
            methods.getCommands();
            
            $interval(function(){
                methods.getCommands();
            },5000);
            
            $scope.ViewVars = object;
            $scope.ViewMethods = methods;
            
            $log = $log.getInstance("CliController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ApiService", CliController];
        
    });

}(define));