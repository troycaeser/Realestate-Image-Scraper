/* @ngInject */
var AdItemController = function(adItemService, $scope){
	this.adItemService = adItemService;
	this.$scope = $scope;
};

AdItemController.prototype.display = function(url){
	var _this = this;

	_this.$scope.$on('dropzoned', function(evt){
		_this.$scope.$apply(function() {
			_this.links = _this.adItemService.Crawl().getData().links;
			_this.address = "word";
		});
	});

    _this.listingType = [
        {
            code: 'JL',
            title: 'Just Listed',
            firstLine: 'JUST',
            secondLine: 'LISTED'
        }
        /*{
            code: 'AC',
            title: 'Auction',
            firstLine: 'Auction this'
        }*/
    ];

	//get data from Service
	_this.adItemService.Crawl().sendData(url)
		.then(function(response){
			_this.show = true;
			_this.links = response.links;
			_this.address = response.propertyInfo.address;
			_this.bedRoom = response.propertyInfo.no_bed;
			_this.bathRoom = response.propertyInfo.no_bath;
			_this.carport = response.propertyInfo.no_car;
			_this.adItemService.Crawl().sendLinks(_this.links);
		});
	console.log('first time send for Crawl');

	//initialise list with links

	//track ui.sortable object

	_this.sortableOptions = {
		stop: function(e, ui){
			var logEntry = _this.links.map(function(i){
				return i;
			});
			//set the list of links through service if dragged
			_this.adItemService.Crawl().sendLinks(logEntry);
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
			templateDirWeb: gotData.templateDirWeb,
		}

		//assign new values for backend
		data.propertyInfo.no_bed = _this.bedRoom;
		data.propertyInfo.no_bath = _this.bathRoom;
		data.propertyInfo.no_car = _this.carport;

		//send all values to backend
		//_this.adItemService.Crawl().sendFinal(data);
        console.log(_this.links);
		console.info('final data sent:\n');
		console.info(data);
	}
}

angular.module('adItem')
	.controller('adItemController', AdItemController);
