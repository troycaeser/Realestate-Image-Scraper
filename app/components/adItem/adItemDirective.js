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
		context.globalCompositeOperation = "source-over";

		var imageObj = new Image();
		var imageBanner = new Image();

		imageObj.onload = function(){
			context.drawImage(imageObj, 0, 0, 80, 60);
			if(scope.out == 0){
				context.drawImage(imageBanner, 0, 0, 40.4, 37.4);
			}
		}

		/*imageBanner.onload = function(){
			context.drawImage(imageBanner, 0, 0)
		}*/

		//get image source from adItemService
		imageObj.src = adItemService.Crawl().getData().links[scope.out];
		imageBanner.src = adItemService.Crawl().getData().templateDir.Banner;
	};
};

angular.module('app')
	.directive('adItem', ['adItemService', AdItemDirective]);
