define(['angular'], function(angular){
	var homeService = angular.module('homeService', []);

	homeService.getStuff = function($http){
		this.http_ = $http;
	}

	homeService.getStuff.prototype.get = function(){
		console.log('services works?');
	}

	homeService
		.service('homeService', homeService.getStuff);
});