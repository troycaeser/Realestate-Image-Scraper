angular.module('app')
	.controller('adItemController', ['adItemService', main]);

function main(adItemService){
	// this.links = "this should be a bunch of links";

	adItemService.getCrawl()
		.success(function(data){
			this.links = data;
		});
};