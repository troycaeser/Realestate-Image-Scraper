var app = angular.module('app');

var AdItemDirective = function(adItemService){
    return {
        restrict: 'AE',
        templateUrl: 'app/components/adItem/adItemDirective.html',
        link: Controls,
        scope:{
            imgsrc: "@"
        }
    }
};

var Controls = function(scope, elem, attrs){
    //define controls
    elem.find('canvas').bind('mouseenter', function(){
        /*elem.find('canvas').css('opacity', '0.5');*/
    });

    elem.find('canvas').bind('mouseleave', function(){
        elem.find('canvas').css('opacity', '1');
    });

    elem.find('canvas').bind('mouseenter', function(){
        //console.log(canvas.toDataURL("image/png"));
        console.log('mouseentered the canvas dawg!');
    });

    elem.find('button').bind('click', function(){
        elem.find('canvas').remove(); 
        elem.remove();
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

    imageObj.src = scope.imgsrc;
    //imageObj.src = adItemService.Templates;
	adItemService

    console.log(adItemService.Templates());
       // .then(function(response){
           //imageObj.src = response.data;
        /*   console.log(response.data);
        });*/
};

app.directive('adItem', ['adItemService', AdItemDirective]);
