(function(define) {
    "use strict";

    /**
     * Register the MainController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var MainController = function($scope, $log, $interval, ApiService)
        {
            $scope.server = {
                Ip : 'Loading...',
                UpTime : 'Loading...',
                Processes : 'Loading...',
                Memory : {
                    total : 1 , 
                    free : 0 , 
                    used : 0 
                }
            }
            
            var requests = {
                serverInfo : function(){
                    ApiService.get('/server-status').then(function(Result){
                        
                        var server = Result.data.Object;
                        $scope.server.Ip = server.listening_ip; 
                        $scope.server.UpTime = server.uptime.days + 'days ' +  server.uptime.hours + 'hours ' + server.uptime.min + 'min';
                        
                        /* Process them processes. */
                        var processes = server.processes;
                        var prs = {sleeping : 0 , running : 0};
                        angular.forEach(processes, function(process, key) {
                            if(process.status == 'R'){
                                prs.running++;
                            } else {
                                prs.sleeping++;
                            }
                        });
                        $scope.server.Processes = processes.length + '(' + prs.running + ' running, ' + prs.sleeping + ' sleeping)';
                        
                        /* Process them memory */
                        var memory = server.memory;
                        $scope.server.Memory.total = Math.round(memory.total / (1024 * 1024) * 10000) / 10000;;
                        $scope.server.Memory.free = memory.free 
                        $scope.server.Memory.used = Math.round(memory.used / (1024 * 1024) * 10000) / 10000;;
                        
                    });;
                }
            };
            //$interval(requests.serverInfo, 5000 );
            requests.serverInfo();
            $log = $log.getInstance("MainController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ApiService", MainController];
        
    });

}(define));