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
                    .when( '/c/all', {
                        templateUrl : ASSETS_PATH + 'views/application/category/landing.html',
                        controller  : 'CategoriesCtrl'
                    })
                    .when( '/c/n', {
                        templateUrl : ASSETS_PATH + 'views/application/category/new.html',
                        controller  : 'CategoryCtrl'
                    })
                    .when( '/c/e/:id', {
                        templateUrl : ASSETS_PATH + 'views/application/category/edit.html',
                        controller  : 'CategoryCtrl'
                    })
                    
                    .when( '/p/all', {
                        templateUrl : ASSETS_PATH + 'views/application/product/landing.html',
                        controller  : 'ProductsCtrl'
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
