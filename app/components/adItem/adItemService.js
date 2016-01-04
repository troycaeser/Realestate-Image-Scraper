var AdItemService = function($http, $q){
	this.$http = $http;
	this.$q = $q;
};

AdItemService.prototype.Crawl = function(){
	var _this = this;

	var get = {
		data: false,
		sendData: function(url){
			var request = {
				url: url
			}

			var deferred = _this.$q.defer();

			var promise = _this.$http.post('api/crawl', request);

				promise.success(function(response){
					_this.data = response.links;
					deferred.resolve({
						links: response.links,
						propertyInfo: response.propertyInfo,
						templateDir: response.templateDir
					});
				});
			return deferred.promise;
		},
		getData: function(){
			return _this.data;
		}
	};

	return get;
}

angular.module('app')
	.service('adItemService', ['$http', '$q', AdItemService]);
