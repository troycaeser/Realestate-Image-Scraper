var AdItemService = function($http, $q){
	this.$http = $http;
	this.$q = $q;
};

AdItemService.prototype.Crawl = function(){
	var _this = this;

	var get = {
		sendData: function(url){
			var request = {
				url: url
			}

			var deferred = _this.$q.defer();

			var promise = _this.$http.post('api/crawl', request);

				promise.success(function(response){
					_this.links = response.links;
					_this.propertyInfo = response.propertyInfo;
					_this.templateDirWeb = response.templateDirWeb;

					deferred.resolve({
						links: response.links,
						propertyInfo: response.propertyInfo,
						templateDirWeb: response.templateDirWeb
					});
				});
			return deferred.promise;
		},
		getData: function(){
			var data = {
				links: _this.links,
				propertyInfo: _this.propertyInfo,
				templateDirWeb: _this.templateDirWeb
			}
			return data;
		}
	};

	return get;
}

angular.module('app')
	.service('adItemService', ['$http', '$q', AdItemService]);
