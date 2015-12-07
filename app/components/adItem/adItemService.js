angular.module('app')
	.service('adItemService', ['$http', main]);

function main($http){
	this.getCrawl = function(){
		return $http.get('api/crawl');
	}
};