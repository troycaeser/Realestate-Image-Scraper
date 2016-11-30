<?php
	require 'vendor/autoload.php';
	include 'tempM/databaseAccess.php';
	include 'models/content.php';
	include 'models/mmscontent.php';

	$app = new \Slim\Slim(array(
		'mode' => 'development'
	));

	require 'routes/crawl.php';

	$app->get('/hello/:name', function($name){
		echo "Hello " . $name;
	});

	$app->get('/', function() use ($app){
		echo 'You have reached the API home route for Linkubi MMS App';
	});

	$app->get('/content', function(){
		$content = new Content();
		$result = $content->getContent();
		header("Content-Type: application/json");
		echo json_encode($result);
	});

	$app->get('/content/:id', function($id){
		$content = new Content();
		$result = $content->getContentById($id);
		header("Content-Type: application/json");
		echo json_encode($result);
	});

	$app->get('/mms_content/:id', function($id){
		$content = new MmsContent();
		$result = $content->getMmsContentById($id);
			/*echo "<pre>";
				print_r($result);
			echo "</pre>";*/
        header("Content-Type: application/json");
        echo json_encode($result);
	});

	function getConnection(){
		$hostname = 'localhost';
		$username = 'root';
		$password = 'root';
		$dbname = 'linkubi';
		$dbh = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);

		return $dbh;
	}

/*
	include "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/lib/getHTMLContents.php";
	$app->get ('/testHTML', function() use ($app) {
		$url = "http://www.realestate.com.au/property-house-vic-mount+waverley-121481678";
		$arr = array();
		getHTML ($url, $arr);
	});
*/
	$app->run();
?>
