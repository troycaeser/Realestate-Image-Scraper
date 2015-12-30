<?php
	require 'vendor/autoload.php';

	$app = new \Slim\Slim(array(
		'mode' => 'development'
	));

	require 'routes/crawl.php';

	$app->get('/hello/:name', function($name){
		echo "Hello " . $name;
	});

	$app->get('/', function() use ($app){
		echo 'Troy is the home for apiasdasdfasdff';
	});

	$app->run();
?>