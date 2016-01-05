var AdItemDirective = function(adItemService){
	var myDirective = {
		restrict: 'AE',
		templateUrl: 'app/components/adItem/adItemDirective.html',
		link: Controls,
		scope:{
			//imgsrc: "@"
			out: "@",
			model: "=",
			remove: "&"
		}
	};

	return myDirective;

	function Controls(scope, elem, attrs, adItemCtrl){
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

		var imageObj = new Image();
		var imageBanner = new Image();
		// imageObj.setAttribute('crossOrigin', '*');

		imageObj.onload = function(){
			context.drawImage(imageObj, 0, 0);
		}

		imageBanner.onload = function(){
			context.drawImage(imageBanner, 0, 0)
		}

		imageObj.src = adItemService.Crawl().getData().links[scope.out];
	};
};

angular.module('app')
	.directive('adItem', ['adItemService', AdItemDirective]);
