var app = angular.module('app');

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

    /*_this.adItemService.Crawl(url)
        .then(function(response){
			var links = response.data.links;
			var propertyInfo = response.data.propertyInfo;
			var templateDir = response.data.templateDir;

            _this.links = response.data.links;

            //displays input fields
            _this.show = true;
			_this.address = rtyInfo.address;
            _this.bedRoom = propertyInfo.no_bed;
            _this.bathRoom = propertyInfo.no_bath;
            _this.carport = propertyInfo.no_car;
        });*/

    /*_this.adItemService.Templates()
        .then(function(response){
            _this.banner = response.data;
        });*/
}

app.controller('adItemController', ['adItemService', AdItemController]);
