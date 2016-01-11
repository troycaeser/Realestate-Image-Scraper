var AdItemDirective = function(adItemService){
	var adItemDirective = {
		restrict: 'AE',
		templateUrl: 'app/components/adItem/adItemDirective.html',
		compile: function(){
			return {
				pre: preLink,
				post: postLink
			}
		},
		controller: Controls,
		//binds "out" with parent scope
		//binds "model" with current scope
		//binds "remove" as a method
		scope:{
			index: "@",
			model: "=",
			remove: "&",
		}
	};

	return adItemDirective;

	function Controls($scope, $element){
		var _this = this;
		var data = adItemService.Crawl().getData();

		var links = data.links;
		var propertyInfo = data.propertyInfo;
		var templateDirWeb = data.templateDirWeb;
		console.log(data);

		//draw images and add alt
		$scope.source = links[$scope.index];
		$scope.addr = propertyInfo.address;

		//draw templates
		$scope.bannerSrc = templateDirWeb.Banner;

		//remove unwanted elements
		if($scope.index != 0){
			$element.find('img.banner').remove();
		}
	}

	function postLink(scope, elem, attrs){
		//postlinks functions here
	}

	function preLink(){

	}

	function oldPreLink(scope, elem, attrs){
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
			//service.templateDirWeb.Logo
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
				if(scope.out > 0){
					drawCanvas(images[0], 0, 0, images[0].naturalWidth, images[0].naturalHeight);
					//drawOther();
				}else{
					drawCanvas(images[0], 0, 0, images[0].naturalWidth, images[0].naturalHeight - 30);
					drawMain();
				}
			};
		}

		function drawCanvas(image, x, y, w, h){
			context.drawImage(image, x, y, w, h);
		}

		function drawMain(){
			//drawCanvas(images[1], service.templateInfo.main.Logo.pos_x, service.templateInfo.main.Logo.pos_y, images[1].naturalWidth, images[1].naturalHeight);
			drawCanvas(images[1], 0, 0, images[1].naturalWidth, images[1].naturalHeight);
			drawCanvas(images[2], 0, 267, images[2].naturalWidth, images[2].naturalHeight + 2);
			drawCanvas(images[3], service.templateInfo.main.Bed.pos_x, service.templateInfo.main.Bed.pos_y, images[3].naturalWidth, images[3].naturalHeight);
			drawCanvas(images[4], service.templateInfo.main.Bath.pos_x, service.templateInfo.main.Bath.pos_y, images[4].naturalWidth, images[4].naturalHeight);
			drawCanvas(images[5], service.templateInfo.main.Car.pos_x, service.templateInfo.main.Car.pos_y, images[5].naturalWidth, images[5].naturalHeight);
			context.save();

			var fontSize = service.templateInfo.main.Text.font_size + "pt ";
			var fonts = service.propertyInfo.agency_localDir;
			context.font = fontSize + fonts;
			context.textBaseline = 'alphabetic';
			var text = service.templateInfo.main.Text;
			context.fillStyle = "rgb(" + text.colour_r + "," + text.colour_g + "," + text.colour_b + ")";
			context.fillText(service.propertyInfo.no_bed, service.templateInfo.main.Bed.t_pos_x, service.templateInfo.main.Bed.t_pos_y);
			context.fillText(service.propertyInfo.no_bath, service.templateInfo.main.Bath.t_pos_x, service.templateInfo.main.Bath.t_pos_y);
			context.fillText(service.propertyInfo.no_car, service.templateInfo.main.Car.t_pos_x, service.templateInfo.main.Car.t_pos_y);
			//context.translate(200, 150);
			var x = service.templateInfo.main.Banner.A.top.t_pos_x;
			var y = service.templateInfo.main.Banner.A.top.t_pos_y;
			var t = Math.sqrt(x*x+y*y);
			var a = Math.acos(y/t);
			var b = 0.76 - a;
			var resultX = -t*Math.cos(b);
			var resultY = t*Math.sin(b);

			context.translate(x, y);
			context.rotate(-0.76);
			context.translate(-x, -y);
			context.fillStyle = "rgb(" + text.colour_banner_r + "," + text.colour_banner_g + "," + text.colour_banner_b + ")";
			fontSize = service.templateInfo.main.Banner.A.top.font_size + "pt ";
			context.font = fontSize + fonts;
			context.fillText("Auction this", x, y);
			context.restore();
			context.save();
			context.fillStyle = "rgb(" + text.colour_banner_r + "," + text.colour_banner_g + "," + text.colour_banner_b + ")";

			var hour = service.propertyInfo.auction_hour.length;
			var text_x = service.templateInfo.main.Banner.A.bottom.Saturday[hour].t_pos_x;
			var text_y = service.templateInfo.main.Banner.A.bottom.Saturday[hour].t_pos_y;

			context.translate(text_x, text_y);
			context.rotate(-0.76);
			context.translate(-text_x, -text_y);
			fontSize = service.templateInfo.main.Banner.A.bottom.Saturday[hour].font_size + "pt ";
			context.font = fontSize + fonts;
			context.fillText(service.propertyInfo.auction_day + " " + service.propertyInfo.auction_hour, text_x, text_y);
			context.restore();
		}

		function drawOther(){
					drawCanvas(images[1], service.templateInfo.other.Logo.pos_x, service.templateInfo.other.Logo.pos_y + 31, images[1].naturalWidth, images[1].naturalHeight);
		}
	};
};

angular.module('app')
	.directive('adItem', ['adItemService', AdItemDirective]);
