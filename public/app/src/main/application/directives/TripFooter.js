(function( define, angular ) {
    "use strict";

    define( [  ], function (  )
    {
           
        var Directive = function( ) {

            return {
                restrict : 'E',
                replace  : true,
                scope    : {
                    
                },
                link: function($scope, element, attrs)
                {
                    
                },
                templateUrl : ASSETS_PATH + 'misc/views/directives/trip-footer.html'
            };
        };

        return Directive;

    });

})( define, angular  );
