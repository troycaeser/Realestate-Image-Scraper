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
