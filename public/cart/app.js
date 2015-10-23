
var app = angular.module('CartApp', ['ngRoute', 'ngResource', 'ngAnimate', 'pascalprecht.translate']);

app.config(function ($routeProvider) {
	'use strict';

	$routeProvider
		.when('/overview', {
		    templateUrl : App.BasePath + '/tpl/cart/overview.html',
            controller  : 'OverviewCtrl'
		})
		.when('/login'   , {
		    templateUrl :  App.BasePath + '/tpl/cart/login.html',
            controller  : 'LoginCtrl'
		})
		.when('/address' , {
		    templateUrl : App.BasePath + '/tpl/cart/address.html',
            controller  : 'AddressCtrl'
		})
		.when('/payment' , {
		    templateUrl : App.BasePath + '/tpl/cart/payment.html',
            controller  : 'PaymentCtrl'
		})
		.otherwise({
			redirectTo: '/overview'
	});
	
    
});

app.config(['$translateProvider', function ($translateProvider) {
  
  $translateProvider.translations('en', Translations);
 
  $translateProvider.translations('ro', Translations);
 
  $translateProvider.preferredLanguage(App.Lang);
}]);


