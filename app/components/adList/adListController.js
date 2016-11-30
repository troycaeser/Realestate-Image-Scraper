/* @ngInject */
var AdListController = function($scope, adListService, $stateParams){
	this.$scope = $scope;
	this.$stateParams = $stateParams;
	this.adListService = adListService;
};

AdListController.prototype.init = function(){
	var _this = this;
	//this is for ID'd types
	_this.contentID = _this.$stateParams.contentID;

	_this.adListService.Content().getData()
		.then(function(response){
			_this.show = true;
			_this.content = response.content;
			console.log(_this.content);
		});
}

angular.module('adList')
	.controller('adListController', AdListController);
