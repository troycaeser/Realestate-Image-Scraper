require.config({
	paths:{
		angular: 'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min',
		angularRoute: 'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular-route'
	},
	shim:{
		angularRoute: {
			deps: ['angular'],
			exports: 'angular'
		},
		angular: {
			exports: 'angular'
		}
	},
	urlArgs: "v=" + (new Date()).getTime()
});

require(['app.module'], function(app){
	app.init();
});