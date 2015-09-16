/**
 *  Use aysnc script loader, configure the application module (for AngularJS)
 *  and initialize the application ( which configures routing )
 *
 *  @author Thomas Burleson
 */

 (function( head ) {
    "use strict";

    head.js(
      // Pre-load these for splash-screen progress bar...
      { jQuery              : "../public/app/vendor/jquery/jquery.js" ,                                             size : "108123" }, 
      { jQuery              : "../public/app/vendor/jquery-ui-1.11.4.custom/jquery-ui.js" ,                         size : "108123" }, 
      { require             : "../public/app/vendor/requirejs/require.js",                                          size: "80196"   },
      { angular             : "../public/app/vendor/angular-1.4.2/angular.js",                                      size: "551057"  },
      { ngRoute             : "../public/app/vendor/angular-1.4.2/angular-route.js",                                size: "30052"   },
      { ngSanitize          : "../public/app/vendor/angular-1.4.2/angular-sanitize.js",                             size: "19990"   },
      { angularbootstrap: "../public/app/vendor/angular-1.4.2/addons/angular-bootstrap/ui-bootstrap-tpls-0.13.0.js",size: "999999"  },
      { ngChart             : "../public/app/vendor/angular-1.4.2/addons/angular-chart/angular-google-chart.js",    size: "999999"  },
      { ckeditor            : "../public/app/vendor/ckeditor/ckeditor.js",                                          size: "999999"  },
      { elfinder            : "../public/app/vendor/elfinder-2.x/js/elfinder.full.js",                              size: "10101"   }
  
    )
    .ready("ALL", function() {

        require.config (
            {
            appDir  : '',
            baseUrl : '../public/app/src',
            paths   :
            {
                // Configure alias to full paths
                'utils'       :     './mindspace/utils',
                'application' :     './main/application',
                'account'     :     './main/account',
                'util'        :     './main/util'
            },
            "shim"  :   {
                'angular' : {'exports' : 'angular'},
            }
        });

        require( [ "main" ], function( app )
        {
            // Application has bootstrapped and started...
        });

    });

}( window.head ));
