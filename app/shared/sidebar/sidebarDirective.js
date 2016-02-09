/* @ngInject */
var SidebarDirective = function(){
	var sidebarDirective = {
		restrict: 'AE',
		templateUrl: 'app/shared/sidebar/sidebarDirective.html',
	};

	return sidebarDirective;
};

angular.module('sidebar')
	.directive('sidebarDirective', SidebarDirective);
