/* @ngInject */
var AdDetailService = function($http, $q){
	this.$http = $http;
	this.$q = $q;
};

AdDetailService.prototype.Frames = function(){
	var _this = this;

	var mms = {
		getData: function(content_id){
			var deferred = _this.$q.defer();
			var promise = _this.$http.get('api/mms_content/' + content_id);

			promise.success(function(response){
				deferred.resolve({
					mms: response
				});
			});
			return deferred.promise;
		}
	};

	return mms;
};

angular.module('adDetail')
	.service('adDetailService', AdDetailService);
