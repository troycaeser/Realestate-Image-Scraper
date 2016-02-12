/* @ngInject */
var AdItemController = function(adItemService, $scope, $rootScope){
	this.adItemService = adItemService;
	this.$scope = $scope;
	this.$rootScope = $rootScope;
};

AdItemController.prototype.setType = function(typeCode){
	var _this = this;

	_this.$rootScope.$broadcast(typeCode);
	_this.listingType = {
		code: 'M',
		title: 'Manual'
	};

	_this.$scope.$on('dropzoned', function(evt){
		console.info("A file was droped.");
		_this.$scope.$apply(function() {
			_this.links = _this.adItemService.Crawl().getData().links;
		});
	});

	_this.sortableOptions = {
		stop: function(e, ui){
			var logEntry = _this.links.map(function(i){
				return i;
			});
		},
		items: ".adItemRow:not(.not-sortable)"
	}
};

AdItemController.prototype.display = function(url){
	var _this = this;

	//if dropzoned is broadcasted, reload _this.links
	_this.$scope.$on('dropzoned', function(evt){
		console.info("A file was droped");
		_this.$scope.$apply(function() {
			_this.links = _this.adItemService.Crawl().getData().links;
		});
	});

	_this.listingType = { code: 'JL' }

	//get data from Service
	console.log(url);
	_this.adItemService.Crawl().sendData(url)
		.then(function(response){
			_this.show = true;
			_this.links = response.links;
			_this.address = response.propertyInfo.address;
			/*_this.bedRoom = response.propertyInfo.no_bed;
			_this.bathRoom = response.propertyInfo.no_bath;
			_this.carport = response.propertyInfo.no_car;*/
			_this.adItemService.Crawl().sendLinks(_this.links);
		});

	console.log('first time send for Crawl');

	//track ui.sortable object
	_this.sortableOptions = {
		stop: function(e, ui){
			var logEntry = _this.links.map(function(i){
				return i;
			});
		},
		items: ".adItemRow:not(.not-sortable)"
	}

	//submit form
	_this.submit = function(){
		//get data and prepare them for new assignment
		var gotData = _this.adItemService.Crawl().getData();
		var data = {
			links: this.links,
			propertyInfo: gotData.propertyInfo,
		}

		//send all values to backend
		_this.adItemService.Crawl().sendFinal(data);
		console.info('final data sent:\n');
		console.info(data);
	}
}

angular.module('adItem')
	.controller('adItemController', AdItemController);
