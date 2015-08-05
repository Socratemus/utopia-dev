/**
 *
 *  Gravatar AngularJS Directive used to display Gravatar image based on specified email.
 *  Uses RequireJS and the md5 cipher in the Crypto module
 *
 *  Usages:
 *
 *       <gravatar email="user.email" size="50" default-image="'monsterid'" ></gravatar>
 *           which injects into the DOM:
 *       '<img ng-src="http://www.gravatar.com/avatar/{{hash}}{{params}}"/>
 *
 *  Configuration:
 *
 *       angular.module( 'myApp')
 *              .directive( 'gravatar', Gravatar );
 *
 *
 *  @author      Thomas Burleson
 *  @copyright   Mindspace, LLC
 *
 *  @see utils.md5
 *
 */
(function( define, angular ) {
    "use strict";

    /**
     * Register the CkEditor construction function with RequireJS
     *
     */
    define( [  ], function (  )
    {
            /**
             * Construction function
             * Does not need any AngularJS DI
             *
             * @constructor
             */
        var CkEditor = function( ) {

            return {
                require: '?ngModel',
                link: function ($scope, elm, attr, ngModel) {
                   
                    var ck = CKEDITOR.replace(elm[0]);
                    console.log('this is ittt');
                    ck.on('pasteState', function () {
                        $scope.$apply(function () {
                            ngModel.$setViewValue(ck.getData());
                        });
                    });
        
                    ngModel.$render = function (value) {
                        ck.setData(ngModel.$modelValue);
                    };
                }
            };
        };

        // Publish the CkEditor directive construction function

        return CkEditor;

    });

})( define, angular  );
