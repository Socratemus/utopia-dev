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
            'application/services/ControllService',
            'application/ApplicationModule',
            'util/UtilModule',
            
        ],
        function ($log, LogDecorator,
            MainRouteManager, ControllSrv ,
            ApplicationModule , UtilModule

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
                            ApplicationModule, UtilModule
                            
                            
                        ]
                    )
                    .config( LogDecorator       )
                    .config( MainRouteManager   )
                    ;
            
            app.run(["$rootScope", "ControllService" , "DomService",function($rootScope, ControllSrv , DomService){
                ControllSrv.apiListeners();
                ControllSrv.appStatuses();
                DomService.init();
                
            }]);
            
            angular.bootstrap( document.getElementsByTagName("body")[0], [ appName ]);
            
            return app;
        }
    );

}( define ));
