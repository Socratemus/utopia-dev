/**
 * 
 */
 
 (function(define, angular) {
    "use strict";

    define([], function(  )
    {

        var Directive = function( $http  ) {

            return {
                require:'ngModel',
                link:function(scope,el,attrs,ngModel){
                  
                  
                  
                  //change event is fired when file is selected
                  el.bind('change',function(){
                    ngModel.$setViewValue(null);
                    var file = el[0].files[0];
                    var fd = new FormData();
                    fd.append('file', file);
                    $(el[0]).parent().prepend('<span class="loader"></span>');
                    $http.post(APP_PATH + '/image', fd, {
                        
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                    }).then(function(Result) {
                        var code = Result.data.Object.image;
                        ngModel.$setViewValue(code);
                        ngModel.$render();
                         $(el[0]).parent().find('.loader').remove();
                    });
                  })
                }
            };
        };

        return [ "$http" , Directive ];

    });

})(define, angular);
