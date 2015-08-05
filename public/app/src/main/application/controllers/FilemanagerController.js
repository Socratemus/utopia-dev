(function(define) {
    "use strict";

    /**
     * Register the FilemanagetController class with RequireJS
     */
    define([], function( )
    {
        /**
         * Constructor function used by AngularJS to create instances of
         * a service, factory, or controller.
         *
         * @constructor
         */
        var FilemanagetController = function($scope, $log, $interval, ControllService)
        {
            $('#elfinder').elfinder({
					url : 'api/file-manager',  // connector URL (REQUIRED)
					resizable : false   
					// , lang: 'ru'                    // language (OPTIONAL)
			});
			var wh = $(window).height(); 
// 			$('div.content').css({'padding-top' : 0}).css({'padding-bottom' : 0});
            $('#elfinder').height(wh - 58);
            $('#elfinder').css({'margin-top' : -15});
            $log = $log.getInstance("FilemanagetController");
            $log.info("constructor() ");
        };

        // Register as global constructor function
        return ["$scope", "$log", "$interval", "ControllService" , FilemanagetController];
        
    });

}(define));