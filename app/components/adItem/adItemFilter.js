var app = angular.module('app');

var AdItemFilter = function($sce){
	return function(url){
		return $sce.trustAsResourceUrl(url);
	};
};

app.filter('trusted', ['$sce', AdItemFilter]);