var AdItemController = function(adItemService){
	// this.links = "this should be a bunch of links";
	this.adItemService = adItemService;
};

AdItemController.prototype.display = function(url){
	var _this = this;
	_this.adItemService.Crawl().sendData(url)
		.then(function(response){
			_this.show = true;
			_this.links = response.links;
			_this.address = response.propertyInfo.address;
			_this.bedRoom = response.propertyInfo.no_bed;
			_this.bathRoom = response.propertyInfo.no_bath;
			_this.carport = response.propertyInfo.no_car;
		});

	_this.sortableOptions = {
		//update: function(e, ui){
			//var logEntry = _this.links.map(function(i){
				//return i;
			//}).join(',\n');
			//console.log("Update: " + logEntry);
		//},
		stop: function(e, ui){
			var logEntry = _this.links.map(function(i){
				return i;
			}).join(",\n");
			console.log("Stop: \n" + logEntry);
		}
	}
}

angular.module('app')
	.controller('adItemController', ['adItemService', AdItemController]);
