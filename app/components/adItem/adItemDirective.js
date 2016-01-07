var AdItemDirective = function(adItemService){
	var myDirective = {
		restrict: 'AE',
		templateUrl: 'app/components/adItem/adItemDirective.html',
		link: Controls,
		//binds "out" with parent scope
		//binds "model" with current scope
		//binds "remove" as a method
		scope:{
			out: "@",
			model: "=",
			remove: "&"
		}
	};

	return myDirective;

	function Controls(scope, elem, attrs){
		console.log(adItemService.Crawl().getData());
		//define controls
		elem.find('canvas').bind('mouseenter', function(){
			/*elem.find('canvas').css('opacity', '0.5');*/
		});

		elem.find('canvas').bind('mouseleave', function(){
			elem.find('canvas').css('opacity', '1');
		});

		var canvas = elem.find('canvas')[0];
		var context = canvas.getContext('2d');
		//context.globalCompositeOperation = "source-over";

		var files = [
			adItemService.Crawl().getData().links[scope.out]
		];

		if(scope.out ==  0){
			files.push(adItemService.Crawl().getData().templateDirWeb.Banner);
			files.push(adItemService.Crawl().getData().templateDirWeb.Bottom);
			files.push(adItemService.Crawl().getData().templateDirWeb.Bed);
			files.push(adItemService.Crawl().getData().templateDirWeb.Bath);
			files.push(adItemService.Crawl().getData().templateDirWeb.Car);
			files.push(adItemService.Crawl().getData().templateDirWeb.Logo);
		}

		var images = [];
		var counter = 0;

		for(var i = 0; i < files.length; i++){
			var imageObj = new Image();
			imageObj.src = files[i];
			images.push(imageObj);
			imageObj.onload = function(){
				drawCanvas(images[0], 0, 0, 400, 300);
				drawCanvas(images[1], 0, 0, 200, 191);
				drawCanvas(images[2], 0, 267, 400, 33);
				drawCanvas(images[3], 29, 267, 67, 32);
				drawCanvas(images[4], 153, 267, 67, 32);
				drawCanvas(images[5], 276, 267, 67, 32);
				drawCanvas(images[6], 247, 5, 148, 34);
				var fontSize = "20pt ";
				var fonts = adItemService.Crawl().getData().propertyInfo.agency_localDir;
				context.font = fontSize + fonts;
				context.textBaseline = 'bottom';
				context.fillStyle = "#000000";
				context.fillText(adItemService.Crawl().getData().propertyInfo.no_bed, 97, 300);
				context.fillText(adItemService.Crawl().getData().propertyInfo.no_bath, 220, 300);
				context.fillText(adItemService.Crawl().getData().propertyInfo.no_car, 343, 300);
				context.save();
				context.rotate(-0.76);
				context.fillStyle = "#ffffff";
				fontSize = "21pt ";
				context.font = fontSize + fonts;
				context.fillText("Auction this", -72, 96);
				fontSize = "19pt ";
				context.font = fontSize + fonts;
				context.fillText(adItemService.Crawl().getData().propertyInfo.auction_day + " " + adItemService.Crawl().getData().propertyInfo.auction_hour, -94, 121);
				context.restore();
			};
		}
		
		function drawCanvas(image, x, y, w, h){
			context.drawImage(image, x, y, w, h);
		}

		//imageObj.onload = function(){
			//context.drawImage(imageObj, 0, 0, 80, 60);
			//context.drawImage(imageBanner, 0, 0, 40.4, 37.4)
			//if(scope.out == 0){
				//context.drawImage(imageBanner, 0, 0, 40.4, 37.4);
			//}
		//}

		//get image source from adItemService
		//imageObj.src = adItemService.Crawl().getData().links[scope.out];
		//imageBanner.src = adItemService.Crawl().getData().templateDirWeb.Banner;
	};
};

angular.module('app')
	.directive('adItem', ['adItemService', AdItemDirective]);
