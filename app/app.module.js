/* @ngInject */
angular.module('dropzone', []);
angular.module('adItem', []);
angular.module('app', ['angular-loading-bar', 'ui.router', 'ui.bootstrap', 'ui.sortable', 'adItem']);

angular.module('app').config(["$stateProvider", "$urlRouterProvider", function($stateProvider, $urlRouterProvider){
	$urlRouterProvider.otherwise('/adItem');

	$stateProvider
		.state('adItem', {
			url: '/adItem',
			templateUrl : 'app/components/adItem/adItem.html',
			controller: 'adItemController',
			controllerAs: 'adItemCtrl'
		});
}]);
