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
            'account/AccountModule',
            'account/RouteManager',
            'util/UtilModule',
            
        ],
        function ($log, LogDecorator,
            MainRouteManager, ControllSrv ,
            ApplicationModule , AccountModule , AccountRouteManager , UtilModule

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
                            ApplicationModule, AccountModule ,UtilModule
                            
                            
                        ]
                    )
                    .config( LogDecorator           )
                    .config( MainRouteManager       )
                    .config( AccountRouteManager    )
                    ;
            
            app.run(["$rootScope", "ControllService" , "DomService" , "DecoratorService"
                ,function($rootScope, ControllSrv , DomService , DecoratorService){
                $rootScope.basePath = BASE_PATH;
                ControllSrv.apiListeners();
                ControllSrv.appStatuses();
                DomService.init();
                DecoratorService.init();
            }]);
            
            angular.bootstrap( document.getElementsByTagName("body")[0], [ appName ]);
            
            return app;
        }
    );

}( define ));
