var app = angular.module('app');

var AdItemDirective = function(){
	return {
		restrict: 'AE',
		templateUrl: 'app/components/adItem/adItemDirective.html',
		link: function(scope, elem, attrs){
			elem.bind('click', function(){
				elem.children().css('background-color', 'red');
				scope.$apply(function(){
					scope.color = "yellow";
				});
			});

			elem.find('img').bind('mouseenter', function(){
				elem.find('img').css('opacity', '0.5');
			});

			elem.find('img').bind('mouseleave', function(){
				elem.find('img').css('opacity', '1');
			})
		}
	}
};

app.directive('adItem', AdItemDirective);