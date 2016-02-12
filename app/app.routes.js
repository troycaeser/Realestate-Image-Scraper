/* @ngInject */
angular.module('adItem').config(function($stateProvider, $urlRouterProvider){
	//temporary home
	$urlRouterProvider.otherwise('/adItem');

	$stateProvider
		.state('adItem', {
			url: '/adItem',
			templateUrl: 'app/components/adItem/adItem.html',
		})

		.state('adItem.crawl', {
			url: '/crawl',
			views:{
				'crawl':{
					templateUrl: 'app/components/adItem/adItemCrawl.html',
					controller: 'adItemController',
					controllerAs: 'adItemCtrl'
				}
			}
		})

		.state('adItem.normal', {
			url: '/normal',
			views:{
				'normal': {
					templateUrl: 'app/components/adItem/adItemNormal.html',
					controller: 'adItemControllerNormal',
					controllerAs: 'adItemCtrl'
				}
			},
		});
});
