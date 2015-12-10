var app = angular.module('app');

var AdItemDirective = function(){
	return {
		restrict: 'AE',
		templateUrl: 'app/components/adItem/adItemDirective.html',
		link: function(scope, elem, attrs){
			elem.find('img').bind('mouseenter', function(){
				elem.find('img').css('opacity', '0.5');
			});

			elem.find('img').bind('mouseleave', function(){
				elem.find('img').css('opacity', '1');
			});

			elem.find('button').bind('click', function(){
				elem.parent().remove();
			})
		}
	}
};

app.directive('adItem', AdItemDirective);