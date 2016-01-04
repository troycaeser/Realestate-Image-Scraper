<?php
	// include_once("{$_SERVER['DOCUMENT_ROOT']}/myApp/api/functions/getHTMLContents.php");
	// include_once("{$_SERVER['DOCUMENT_ROOT']}/myApp/api/functions/linkProcessing.php");
	// include_once("{$_SERVER['DOCUMENT_ROOT']}/myApp/api/functions/makeTemplateDir.php");
	// include_once("{$_SERVER['DOCUMENT_ROOT']}/myApp/api/functions/resize.php");
	// include_once("{$_SERVER['DOCUMENT_ROOT']}/myApp/api/functions/finaliseMain.php");
	
	include_once("{$_SERVER['DOCUMENT_ROOT']}/api/functions/getHTMLContents.php");
	include_once("{$_SERVER['DOCUMENT_ROOT']}/api/functions/linkProcessing.php");
	include_once("{$_SERVER['DOCUMENT_ROOT']}/api/functions/makeTemplateDir.php");
	include_once("{$_SERVER['DOCUMENT_ROOT']}/api/functions/resize.php");
	include_once("{$_SERVER['DOCUMENT_ROOT']}/api/functions/finaliseMain.php");

	$app->post('/crawl', function() use ($app){
		//get parameter via json_decode()->name
		$request = $app->request();
		$body = $request->getBody();
		$result = json_decode($body);
		$site;

		$url = $result->url;

		$links = array();
		finaliseLinks($url, $links);

		$propertyInfo = array();
		getHTML($url, $propertyInfo);


		$templateDir = array();
		makeTemplateDir($url, $propertyInfo, $templateDir);

		$result = array(
			'links' => $links,
			'propertyInfo' => $propertyInfo,
			'templateDir' => $templateDir
		);

		header("Content-Type: application/json");
		echo json_encode($result);
	});

	$app->get('/test', function() use ($app){
		$url = "http://www.realestate.com.au/property-apartment-vic-elwood-121478162";
		
		$propertyInfo = array();
		getHTML ($url, $propertyInfo);
		
		$templateDir = array();
		makeTemplateDir ($url, $propertyInfo, $templateDir);

		echo "<pre>";
			print_r ($propertyInfo);
		echo "</pre>";
		
		// $imgUrl = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/testDraw/main.jpg";
		$imgUrl = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/testDraw/main.jpg";
		
		finaliseMainAdItem ($url, $imgUrl);
	});
?>
