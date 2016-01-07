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

        var files = [
            adItemService.Crawl().getData().links[scope.out]
        ];

        //if current directive is the first directive, push in the banner
        if(scope.out ==  0){
            files.push(adItemService.Crawl().getData().templateDirWeb.Banner);
        }

        var images = [];
        var counter = 0;

        //loop and load in all images
        for(var i = 0; i < files.length; i++){
            var imageObj = new Image();
            imageObj.src = files[i];
            images.push(imageObj);
            //once loaded, draw images
            imageObj.onload = function(){
                if(++counter == files.length){
                    context.drawImage(images[0], 0, 0, 80, 60);
                    //if there are more than 1 image in the image array
                    //draw rest of the images
                    if(files.length > 1){
                        context.drawImage(images[1], 0, 0, 40.4, 37.4)
                    }
                }
            };
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
