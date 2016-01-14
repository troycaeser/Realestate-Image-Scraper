/* @ngInject */
angular.module('adItem').config(function($stateProvider, $urlRouterProvider){
	//temporary home
	$urlRouterProvider.otherwise('/adItem');

	$stateProvider
		.state('adItem', {
			url: '/adItem',
			templateUrl : 'app/components/adItem/adItem.html',
			controller: 'adItemController',
			controllerAs: 'adItemCtrl'
		});
});
