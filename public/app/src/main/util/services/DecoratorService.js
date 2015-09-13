(function(define) {
    "use strict";

    /**
     * Register the Decorator class with RequireJS
     * Decorates the rootScope object with different functions.
     */
    define([], function() {

        var Decorator = function($rootScope, $log , $timeout ) {
            
            var _instance = {
                
                slugify : function( Object , From , To ) {
                    var value = Object[From],
                    slug = '';
                    slug = value.toLowerCase().replace(/-+/g, '').replace(/\s+/g, '-').replace(/[^a-z0-9-]/g, '');
                    Object[To] = slug;
                },
                
                init : function(){
                    
                    $rootScope._slugify = this.slugify;
                    $log.info('Initialize DecoratorService ');
                }
                
            };

            return _instance;

        };

        return ["$rootScope", "$log" , "$timeout", Decorator];

    });


}(define));