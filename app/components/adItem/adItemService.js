var app = angular.module('app');

var AdItemService = function($http, $q){
	this.$http = $http;
	this.$q = $q;
};

AdItemService.prototype.Crawl = function(url){
	var request = {
		url: url
	};

	return this.$http.post('api/crawl', request);
}

AdItemService.prototype.Templates = function(){
   // return this.$http.get('api/test');
      return "hello";
};

app.service('adItemService', ['$http', AdItemService]);
