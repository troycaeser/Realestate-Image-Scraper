<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/api/functions/getHTMLContents.php");
    include("{$_SERVER['DOCUMENT_ROOT']}/api/functions/linkProcessing.php");

    $app->post('/crawl', function() use ($app){
        //get parameter via json_decode()->name
        $request = $app->request();
        $body = $request->getBody();
        $result = json_decode($body);
        $site;

        $url = $result->url;

        $targets = array('realestate.com.au', 'milesre.com.au', 'portplus.com');

        foreach($targets as $t)
        {
            if (strpos($url, $t) !== false) {
                $site = $t;
                break;
            }
        }
        //figureout which site we're searching
        switch($site){
            case "realestate.com.au":
                $pageLinks = resolvePageLinks($url);
                $carouselLink = cleanLinks('~(photogal)~i', $pageLinks);
                $imgLinks = getImgLinks($carouselLink[0]);
                $cleanedImgLinks = cleanLinks('~(65x48)~i', $imgLinks);
                $resizedImgLinks = resizeLinks($cleanedImgLinks, '65x48', '400x300');
                break;
            case "milesre.com.au":
            case "portplus.com":
                $imgLinks = getImgLinks($url);
                $cleanedImgLinks = cleanLinks('~(width=61)~i', $imgLinks);
                $resizedImgLinks = resizeLinks($cleanedImgLinks, 'width=61', 'width=400');
                break;
        }
        header("Content-Type: application/json");
        echo json_encode($resizedImgLinks);
    });

    $app->get('/test', function() use ($app){
        echo "test totally works yay :D";
    });
?>
