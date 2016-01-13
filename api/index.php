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
		echo 'You have reached the API home route for Linkubi MMS App';
	});

	$app->get('/agency', function(){
		$dbh = getConnection();

		$sql = "SELECT * FROM agency";
		$stmt = $dbh->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchALL(PDO::FETCH_OBJ);

		echo json_encode($rows);
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
