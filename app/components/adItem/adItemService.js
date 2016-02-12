/* @ngInject */
var AdItemService = function($http, $q, $rootScope){
	this.$http = $http;
	this.$q = $q;
	this.$rootScope = $rootScope;
};

AdItemService.prototype.Content = function(){
	var _this = this;

	var content = {
		getData: function(){
			var deferred = _this.$q.defer();
			var promise = _this.$http.get('api/content');

			promise.success(function(response){
				_this.blah = response.links;

				console.log(response);
			});

			return deferred.promise;
		}
	};
	return content;
};

AdItemService.prototype.Crawl = function(){
	var _this = this;

	var crawl = {
		sendData: function(url){
			var request = {
				url: url
			}

			var deferred = _this.$q.defer();
			var promise = _this.$http.post('api/crawl', request);

			promise.success(function(response){
				//assign custom adItemService values after response
				_this.links = response.links;
				_this.propertyInfo = response.propertyInfo;
				_this.templateDirWeb = response.templateDirWeb;
				_this.templateInfo = response.templateInfo;
				console.log(response);

				//defer returned values
				deferred.resolve({
					links: response.links,
					propertyInfo: response.propertyInfo,
					templateDirWeb: response.templateDirWeb,
					templateInfo: response.templateInfo
				});
			});

			return deferred.promise;
		},
		getData: function(){
			//return assigned data from initial request
			var data = {
				links: _this.links,
				propertyInfo: _this.propertyInfo,
				templateDirWeb: _this.templateDirWeb,
				templateInfo: _this.templateInfo
			}
			return data;
		},
		sendLinks: function(input){
			_this.links = input;
		},
		addLinks: function(input){
			if(_this.links){
				_this.links.push(input);
			}
			else{
				_this.links = new Array();
				_this.links.push(input);
			}

			console.info('added: ' + input.name + "into list");

			_this.$rootScope.$broadcast('dropzoned');
		},
		sendFinal: function(data){
			var promise = _this.$http.post('api/sendFinal', data);

			promise.success(function(response){
				console.log(response);
			});
		}
	};
	return crawl;
}

angular.module('adItem')
	.service('adItemService', AdItemService);
