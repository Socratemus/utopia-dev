(function(define, angular) {
    "use strict";

    define([], function(  )
    {

        var Directive = function(  ) {

            return {
                restrict: 'E',
                replace: true,
                scope: {
                },
                link: function($scope, element, attrs)
                {
                   
                },
                templateUrl: ASSETS_PATH + 'misc/views/directives/reservation-statuses.html'
            };
        };

        return [ Directive ];

    });

})(define, angular);
