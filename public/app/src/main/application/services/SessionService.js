(function (define ) {
    "use strict";

    /**
     * Register the Session class with RequireJS
     */
    define( [], function ( ) {
        
        var _session = {
            
            _container : [],
            
            _set : function ( Key , Value ){
                console.log('Set session for [ ' + Key + ']' + ' to value [' + Value + ']');
            },
            
            _get : function( Key ){
                console.log('Return value of key [' + Key + ']');
            },
            
        };
        
        
        return function () {
            return _session;
        };

    });


}( define  ));
