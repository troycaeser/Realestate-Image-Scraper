var AdItemController = function(adItemService){
	// this.links = "this should be a bunch of links";
	this.adItemService = adItemService;
    this.test = true;
    this.newLinks;
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

    var logEntry;
	_this.sortableOptions = {
		//update: function(e, ui){
			//var logEntry = _this.links.map(function(i){
				//return i;
			//}).join(',\n');
			//console.log("Update: " + logEntry);
		//},
		stop: function(e, ui){
			logEntry = _this.links.map(function(i){
				return i;
			});
            _this.adItemService.Crawl().sendLinks(logEntry);
			//console.log("Stop: \n" + logEntry);
		},
        items: ".adItemRow:not(.not-sortable)"
	}

    _this.submit = function(){
        var gotData = _this.adItemService.Crawl().getData();
        var data = {
            links: this.links,
            propertyInfo: gotData.propertyInfo,
            templateDirWeb: gotData.templateDirWeb,
            myWallet: gotData.myWallet
        }

        data.propertyInfo.no_bed = _this.bedRoom;
        data.propertyInfo.no_bath = _this.bathRoom;
        data.propertyInfo.no_car = _this.carport;
        console.log(data);
        _this.adItemService.Crawl().sendFinal(data);
        //console.log(_this.adItemService.Crawl().getLinks());
    }
    
    function set(links){
        this.newLinks = links;
    }
}

//AdItemController.prototype.submit = function(){
    //var _this = this;
	//_this.adItemService.Crawl().sendData(url)
    //_this.adItemService.Crawl().getData().propertyInfo.no_bed = this.bedRoom;
    //console.log(adItemService.Crawl().getData());
//}

angular.module('app')
	.controller('adItemController', ['adItemService', AdItemController]);
