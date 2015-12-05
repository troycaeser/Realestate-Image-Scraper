define(function(require){
	'user strict';

	var angular = require('angular');
	var uiRouter = require('angularUIRoute');
	var taskController = require('components/taskController');

	// var app = angular.module('app', ['ngRoute', 'taskController']);
	var app = angular.module('app', ['ui.router', 'taskController']);

	app.init = function(){
		angular.bootstrap(document, ['app']);
	};

	app.config(function($stateProvider, $urlRouterProvider){
		$urlRouterProvider.otherwise('/home');

		$stateProvider
			.state('home', {
				url: '/home',
				templateUrl : 'index.html'
			});
	});

	return app;
});