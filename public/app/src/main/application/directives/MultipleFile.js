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
                        // var modelFile = {
                        //     id   : 'undefined',
                        //     src  : 'undefined',
                        //     file : el
                        // };
                        
                        // modelFiles.push(modelFile);
                        
                        // if (FileReader && files && files.length) {
                        //     var fr = new FileReader();
                        //     fr.onload = function () {
                        //         var src= fr.result;
                        //         modelFiles[index].src = src;
                        //     }
                        //     fr.readAsDataURL(el);
                        // }

                        fd.append('file[]', el);
                       
                    });
                    
                    var apply = function( Object ){
                        ngModel.$setViewValue(Object);
                        ngModel.$render();
                    }
                    
                    $http.post('/public/api/image/bulk', fd, {
                        transformRequest: angular.identity,
                        headers: {'Content-Type': undefined}
                    }).then(function(Result) {
                        var modelValue = ngModel.$modelValue; 
                        angular.forEach(Result.data.Object, function(Image, key) {
                            modelFiles[key] = {};
                            modelFiles[key].id = Image.hashcode;
                            modelFiles[key].src = Image.src;
                        });
                        if(! modelValue ) modelValue = [];
                        var setValue = modelValue.concat(modelFiles);
                        apply(setValue);
                        $(el[0]).parent().find('.loader').remove(); //Remove loader.
                        // var toSet = [{},{},{},{}];
                        // console.log(ngModel.$modelValue);
                        // 
                        // $timeout(function(){
                        //     if(ngModel.$modelValue == undefined) {
                        //         ngModel.$setViewValue(modelFiles);
                        //     } else {
                        //         //var setValue = ngModel.$modelValue.concat(modelFiles);
                        //         //ngModel.$setViewValue(modelFiles);    
                        //     }
                        
                        //     ngModel.$render();
                            
                        // },200);

                    });
                  })
                }
            };
        };

        return [ "$http" , "$timeout" , MultipleFile ];

    });

})(define, angular);
