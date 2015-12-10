var app = angular.module('app', ['angular-loading-bar', 'ui.router']);

app.config(function($stateProvider, $urlRouterProvider){
	$urlRouterProvider.otherwise('/adItem');

	$stateProvider
		.state('adItem', {
			url: '/adItem',
			templateUrl : 'app/components/adItem/adItem.html',
			controller: 'adItemController',
			controllerAs: 'adItemCtrl'
		});
});