<?php
	$app->post('/crawl', function() use ($app){
		//get parameter via json_decode()->name

		$request = $app->request();
		$body = $request->getBody();
		$result = json_decode($body);

		echo $result->pew_pew;
	});

	$app->get('/crawl', function(){
		echo "get crawl works";
	});
?>