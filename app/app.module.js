define(function(require){
	'user strict';

	var angular = require('angular');
	var ngRoute = require('angularRoute');
	var taskController = require('components/taskController');

	var app = angular.module('app', ['ngRoute', 'taskController']);

	app.init = function(){
		angular.bootstrap(document, ['app']);
	};

	app.config(function($routeProvider){
		$routeProvider
			.when('/', {
				templateUrl : 'index.html',
				controller : 'stuff'
			});
	});

	return app;
});