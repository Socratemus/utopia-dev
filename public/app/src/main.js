/**
 * Now let's start our AngularJS app...
 * which uses RequireJS to load  packages and code
 *
 */
(function ( define ) {
    "use strict";

    define([
            'utils/logger/ExternalLogger',
            'utils/logger/LogDecorator',
            
            'application/RouteManager',
            'application/ApplicationModule',
            
        ],
        function ($log, LogDecorator,
            MainRouteManager,
            ApplicationModule

            )
        {
            /**
             * Specify main application dependencies...
             * one of which is the Authentication module.
             *
             * @type {Array}
             */
            var app, appName = 'AdminAPP';
            
            $log = $log.getInstance( "BOOTSTRAP" );
            $log.info( "Initializing {0}", [ appName ] );

            /**
             * Start the main application
             *
             * We manually start this bootstrap process; since ng:app is gone
             * ( necessary to allow Loader splash pre-AngularJS activity to finish properly )
             */
            app = angular
                    .module(
                        appName,
                        [ "ngRoute", "ngSanitize", "ui.bootstrap", "googlechart" ,
                            ApplicationModule
                        ]
                    )
                    .config( LogDecorator       )
                    .config( MainRouteManager   )
                    ;
            
            // app.run(["$rootScope", "ControllService",function($rootScope, ControllService){
            //     ControllService.apiListeners();
                
            // }]);
            
            angular.bootstrap( document.getElementsByTagName("body")[0], [ appName ]);
            
            return app;
        }
    );

}( define ));
