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
                    .when( '/p/n', {
                        templateUrl : ASSETS_PATH + 'views/application/product/new.html',
                        controller  : 'ProductCtrl'
                    })
                    .when( '/p/e/:id', {
                        templateUrl : ASSETS_PATH + 'views/application/product/edit.html',
                        controller  : 'ProductCtrl'
                    })
                    
                    .when( '/file-manager', {
                        templateUrl : ASSETS_PATH + 'views/application/filemanager/landing.html',
                        controller  : 'FilemanagerCtrl'
                    })
                    
                    .when( '/drive', {
                        templateUrl : ASSETS_PATH + 'views/application/google-drive/landing.html',
                        controller  : 'GoogleDriveCtrl'
                    })
                    
                    .when( '/cli', {
                        templateUrl : ASSETS_PATH + 'views/application/cli/landing.html',
                        controller  : 'CliCtrl'
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
