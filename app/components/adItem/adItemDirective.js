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
		//define controls
		elem.find('canvas').bind('mouseenter', function(){
			/*elem.find('canvas')jcss('opacity', '0.5');*/
		});

		elem.find('canvas').bind('mouseleave', function(){
			elem.find('canvas').css('opacity', '1');
		});

		var canvas = elem.find('canvas')[0];
		var context = canvas.getContext('2d');
		//context.globalCompositeOperation = "source-over";
		
		var service = adItemService.Crawl().getData();
		console.log(service);

		var files = [
			service.links[scope.out],
			service.templateDirWeb.Logo
		];

		if(scope.out ==  0){
			files.push(service.templateDirWeb.Banner);
			files.push(service.templateDirWeb.Bottom);
			files.push(service.templateDirWeb.Bed);
			files.push(service.templateDirWeb.Bath);
			files.push(service.templateDirWeb.Car);
		}

		var images = [];
		var counter = 0;

		for(var i = 0; i < files.length; i++){
			var imageObj = new Image();
			imageObj.src = files[i];
			images.push(imageObj);
			imageObj.onload = function(){
				drawCanvas(images[0], 0, 0, images[0].naturalWidth, images[0].naturalHeight);
				if(scope.out == 0)
					drawCanvas(images[1], service.myWallet.main.Logo.pos_x, service.myWallet.main.Logo.pos_y, images[1].naturalWidth, images[1].naturalHeight);
				else
					drawCanvas(images[1], service.myWallet.other.Logo.pos_x, service.myWallet.other.Logo.pos_y + 31, images[1].naturalWidth, images[1].naturalHeight);

				drawCanvas(images[2], 0, 0, images[2].naturalWidth, images[2].naturalHeight);
				drawCanvas(images[3], 0, 267, images[3].naturalWidth, images[3].naturalHeight);
				drawCanvas(images[4], service.myWallet.main.Bed.pos_x, service.myWallet.main.Bed.pos_y, images[4].naturalWidth, images[4].naturalHeight);
				drawCanvas(images[5], service.myWallet.main.Bath.pos_x, service.myWallet.main.Bath.pos_y, images[5].naturalWidth, images[5].naturalHeight);
				drawCanvas(images[6], service.myWallet.main.Car.pos_x, service.myWallet.main.Car.pos_y, images[6].naturalWidth, images[6].naturalHeight);
				context.save();

				var fontSize = service.myWallet.main.Text.font_size + "pt ";
				var fonts = service.propertyInfo.agency_localDir;
				context.font = fontSize + fonts;
				context.textBaseline = 'bottom';
				context.fillStyle = "#000000";
				context.fillText(service.propertyInfo.no_bed, service.myWallet.main.Bed.t_pos_x, service.myWallet.main.Bed.t_pos_y + 6);
				context.fillText(service.propertyInfo.no_bath, service.myWallet.main.Bath.t_pos_x, service.myWallet.main.Bath.t_pos_y + 6);
				context.fillText(service.propertyInfo.no_car, service.myWallet.main.Car.t_pos_x, service.myWallet.main.Car.t_pos_y + 6);
				context.rotate(-0.76);
				context.fillStyle = "#ffffff";
				fontSize = service.myWallet.main.Banner.A.top.font_size + "pt ";
				context.font = fontSize + fonts;
				context.fillText("Auction this", service.myWallet.main.Banner.A.top.t_pos_x - 88, service.myWallet.main.Banner.A.top.t_pos_y - 20);

				var hour = service.propertyInfo.auction_hour.length;
				var text_x = service.myWallet.main.Banner.A.bottom.Saturday[hour].t_pos_x - 107;
				var text_y = service.myWallet.main.Banner.A.bottom.Saturday[hour].t_pos_y - 31;

				//if(hour == 7){
					//text_x -= 107;
					//text_y -= 31;
				//}
					
				fontSize = service.myWallet.main.Banner.A.bottom.Saturday[hour].font_size + "pt ";
				context.font = fontSize + fonts;
				context.fillText(service.propertyInfo.auction_day + " " + service.propertyInfo.auction_hour, text_x, text_y);
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
		//imageObj.src = service.links[scope.out];
		//imageBanner.src = service.templateDirWeb.Banner;
	};
};

angular.module('app')
	.directive('adItem', ['adItemService', AdItemDirective]);
