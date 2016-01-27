/* @ngInject */
var AdItemService = function($http, $q, $rootScope){
	this.$http = $http;
	this.$q = $q;
	this.$rootScope = $rootScope;
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
			_this.newlinks = input;
			return _this.newLinks;
		},
		addLinks: function(input){
			_this.newlinks.push(input);
			console.log('added: ' + input.name + "into list");
			_this.$rootScope.$broadcast('dropzoned');
            //console.log(_this.newlinks);
			return _this.newlinks;
		},
		getLinks: function(){
			var newlinks = _this.newlinks;
			return newlinks;
		},
		sendFinal: function(data){
			var promise = _this.$http.post('api/sendFinal', data);
		}
	};
	return crawl;
}

angular.module('adItem')
	.service('adItemService', AdItemService);
