var app = angular.module('app');

var AdItemService = function($http, $q){
	this.$http = $http;
	this.$q = $q;

	// get/ set
};

AdItemService.prototype.Crawl = function(url){
	var request = {
		url: url
	};

	return {
		getResource: function(){
			var promise = this.$http.post('api/crawl', request)
				.then(function(response){
					return response.data;	
				});
			return promise;
		}
	};

	//return this.$http.post('api/crawl', request);
}

AdItemService.prototype.Templates = function(){
   // return this.$http.get('api/test');
      return "hello";
};

app.service('adItemService', ['$http', AdItemService]);
