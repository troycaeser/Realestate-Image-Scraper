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

			elem.bind('mouseover', function(){
				elem.children().css('background-color', 'yellow');
			});
		}
	}
};

app.directive('adItem', AdItemDirective);