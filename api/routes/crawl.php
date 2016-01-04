<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/api/functions/getHTMLContents.php");
    include("{$_SERVER['DOCUMENT_ROOT']}/api/functions/linkProcessing.php");
    include("{$_SERVER['DOCUMENT_ROOT']}/api/functions/makeTemplateDir.php");

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
        echo "test totally works yay :D";
    });
?>
