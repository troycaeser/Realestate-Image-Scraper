/* @ngInject */
angular.module('fileUpload', []);
angular.module('sidebar', []);
angular.module('adItem', [
	'fileUpload',
]);

/* @ngInject */
angular.module('loading-bar', ['angular-loading-bar'])
.config(function(cfpLoadingBarProvider){
	cfpLoadingBarProvider.includeSpinner = false;
});

angular.module('core', [
	'loading-bar',
	'ui.router',
	'ui.bootstrap',
	'ui.sortable',
	'ngAnimate'
]);

angular.module('app', [
	'core',
	'adItem',
	'sidebar'
]);
