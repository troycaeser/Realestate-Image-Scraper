/* @ngInject */
var AdDetailController = function($scope, $stateParams, adDetailService){
	this.$scope = $scope;
	this.adDetailService = adDetailService;
	this.$stateParams = $stateParams;
};

AdDetailController.prototype.init = function(){
	var _this = this;
	//this is for ID'd types
	_this.contentID = _this.$stateParams.contentID;

	_this.adDetailService.Frames().getData(_this.contentID)
		.then(function(response){
			_this.show = true;
			console.log(response);
			_this.mms = response.mms;
		});

	_this.sortableOptions = {
		stop: function(e, ui){
			var logEntry = _this.mms.map(function(i){
				return i;
			});
		}
	}

};

angular.module('adDetail')
	.controller('adDetailController', AdDetailController);
