var app = angular.module('app');

var Trusted = function($sce){
	return function(url){
		return $sce.trustAsResourceUrl(url);
	};
};

app.filter('trusted', ['$sce', Trusted]);