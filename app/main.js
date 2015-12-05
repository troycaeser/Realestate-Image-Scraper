require.config({
	paths:{
		angular: 'https://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular.min',
		angularUIRoute: 'https://cdnjs.cloudflare.com/ajax/libs/angular-ui-router/0.2.15/angular-ui-router'
	},
	shim:{
		angularUIRoute:{
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