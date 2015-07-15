(function ( define ) {
    'use strict';


    define([ 
        'utils/logger/ExternalLogger',
    ],
        function ( $log )
        {
            var RouteManager = function ( $routeProvider )
            {
                //$log.debug( 'Configuring application $routeProvider...');

                $routeProvider
                    .when( '/home', {
                        templateUrl : ASSETS_PATH + 'views/application/landing.html',
                        controller  : 'MainCtrl'
                    })
                    .when( '/test', {
                        templateUrl : ASSETS_PATH + 'views/application/test.html',
                        //controller  : 'MainController'
                    })
                    .otherwise({
                        redirectTo  : '/home'
                    });

            };

            //$log = $log.getInstance( 'RouteManager' );

            return ["$routeProvider", RouteManager ];
        });


}( define ));
