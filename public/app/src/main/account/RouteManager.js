(function ( define ) {
    'use strict';
    /**************************************************************************/
    /*
    /**************************************************************************/
    define([ 
        'utils/logger/ExternalLogger',
    ],
        function ( $log )
        {
            var RouteManager = function ( $routeProvider )
            {
                $routeProvider
                    .when( '/overview', {
                        templateUrl : ASSETS_PATH + 'views/account/landing.html',
                        controller  : 'IndexCtrl'
                    })
                ;
            };

            //$log = $log.getInstance( 'RouteManager' );

            return ["$routeProvider", RouteManager ];
        });


}( define ));
