var app = angular.module('app');

var AdItemService = function($http, $q){
	this.$http = $http;
	this.$q = $q;
};

AdItemService.prototype.getCrawl = function(){
	return this.$http.get('api/crawl')
		.then(function(response){
			return response;
		});
}

AdItemService.prototype.Crawl = function(url){
	var request = {
		url: url
	};

	return this.$http.post('api/crawl', request);
}

app.service('adItemService', ['$http', AdItemService]);