/**
 * 
 */
 
 (function(define, angular) {
    "use strict";

    define([], function(  )
    {

        var MultipleFile = function( $http , $timeout , $parse) {

            return {
                require:'ngModel',
                link:function(scope,el,attrs,ngModel){

                  //change event is fired when file is selected
                  el.bind('change',function(){
                    
                    //Show small loading spinner.
                    $(el[0]).parent().prepend('<span class="loader"></span>');
                    
                    //ngModel.$setViewValue(null);
                    var files = el[0].files;
                    var galery = $(el[0]).parent().parent().find('#Galery');
                    var interval = 1000;
                    
                    var fd = new FormData();
                    
                    var modelFiles = [];
                    
                    $(files).each(function(index, el){
                        var modelFile = {
                            id   : 'undefined',
                            src  : 'undefined',
                            file : el
                        };
                        
                        modelFiles.push(modelFile);
                        
                        if (FileReader && files && files.length) {
                            var fr = new FileReader();
                            fr.onload = function () {
                                var src= fr.result;
                                modelFiles[index].src = src;
                            }
                            fr.readAsDataURL(el);
                        }

                        fd.append('file[]', el);
                       
                    });
                   
                    $http.post('/public/api/image/bulk', fd, {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                    }).then(function(Result) {
                        console.log('RECEIVED THE RESULTS');
                        
                        angular.forEach(Result.data.Object, function(hashcode, key) {
                            modelFiles[key].id = hashcode;
                        });
                        
                        $timeout(function(){
                            
                            if(ngModel.$modelValue == undefined) {
                                ngModel.$setViewValue(modelFiles);
                            } else {
                                ngModel.$setViewValue(ngModel.$modelValue.concat(modelFiles));    
                            }
                            $(el[0]).parent().find('.loader').remove(); //Remove loader.
                            ngModel.$render();
                        },200);

                    });
                  })
                }
            };
        };

        return [ "$http" , "$timeout" , MultipleFile ];

    });

})(define, angular);
