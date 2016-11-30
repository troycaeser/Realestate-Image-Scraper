/* @ngInject */
angular.module('app').config(function($stateProvider, $urlRouterProvider){
	//temporary home
	$urlRouterProvider.otherwise('/adList');

	$stateProvider
		.state('adList', {
			url: '/adList',
			templateUrl: 'app/components/adList/adList.html',
			controller: 'adListController',
			controllerAs: 'adListCtrl'
		});

	$stateProvider
		.state('adDetail',{
			url: '/adDetail/:contentID',
			templateUrl: 'app/components/adDetail/adDetail.html',
			controller: 'adDetailController',
			controllerAs: 'adDetailCtrl'
		});

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

		.state('adItem.list', {
			url: '/list/:contentID',
			views:{
				'list': {
					templateUrl: 'app/components/adItem/adItemNormal.html',
					controller: 'adItemControllerNormal',
					controllerAs: 'adItemCtrl'
				}
			},
		});

		//build a new "content" section for each listItem
});
