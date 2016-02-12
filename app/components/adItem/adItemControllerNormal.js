/* @ngInject */
var AdItemControllerNormal = function(adItemService, $scope, $rootScope){
	this.adItemService = adItemService;
	this.$scope = $scope;
	this.$rootScope = $rootScope;
};

AdItemControllerNormal.prototype.init = function(){
	var _this = this;

	_this.adItemService.Content().getData()
		.then(function(response){
			console.log(response);
		});
};

angular.module('adItem')
	.controller('adItemControllerNormal', AdItemControllerNormal);
