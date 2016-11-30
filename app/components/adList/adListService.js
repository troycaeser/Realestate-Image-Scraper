/* @ngInject */
var AdListService = function($http, $q){
	this.$http = $http;
	this.$q = $q;
};

AdListService.prototype.Content = function(){
	var _this = this;

	var content = {
		getData: function(){
			var deferred = _this.$q.defer();
			var promise = _this.$http.get('api/content');

			promise.success(function(response){
				deferred.resolve({
					content: response
				});
			});
			return deferred.promise;
		}
	};

	return content;
};

angular.module('adList')
	.service('adListService', AdListService);
