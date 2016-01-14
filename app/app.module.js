/* @ngInject */
angular.module('fileUpload', []);
angular.module('adItem', [
	'fileUpload',
	'ngAnimate'
]);

angular.module('core', [
	'angular-loading-bar',
	'ui.router',
	'ui.bootstrap',
	'ui.sortable'
]);

angular.module('app', [
	'core',
	'adItem'
]);
