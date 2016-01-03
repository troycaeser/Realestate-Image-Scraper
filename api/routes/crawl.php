<?php
    include("{$_SERVER['DOCUMENT_ROOT']}/api/lib/writeJson.php");
    //include "../lib/writeJson.php";

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

        // print_r($cleanedImgLinks);
        // print_r($resizedImgLinks);

        //test section
        header("Content-Type: application/json");
        echo json_encode($resizedImgLinks);
    });

    $app->get('/crawl', function(){
        echo "get crawl works";
    });

    //need the link, the replacement, matches, the offset
    function resizeLinks($links, $haystack, $needle){
        foreach($links as $key => $value){
            $pos = strpos($value, $haystack);
            $links[$key] = substr_replace($value, $needle, $pos, strlen($haystack));
        }
        return $links;
    }

    function cleanLinks($matchCriteria, $links){
        $matched[] = preg_grep($matchCriteria, $links);
        $matched_key = key($matched);
        $matchedArray = $matched[$matched_key];
        $matchedArray = array_values($matchedArray);

        return $matchedArray;
    }

    //Returns a single link to the required images
    function resolvePageLinks($url){
        //NEED LOGIC TO FIGURE OUT WHICH WEBSITE IT IS SEARCHING

        //Set execution time to unlimited
        set_time_limit(0);

        //get html page
        $html=file_get_contents($url);

        preg_match_all("/<a(s*[^>]+s*)href=([\"|']?)([^\"'>\s]+)([\"|']?)/ies",$html,$out);
        $href = $out[3];
        $arrUrl = parse_url($url);

        if(isset($arrUrl['path'])&&!empty($arrUrl['path'])){
            $dir=str_replace("\\","/",$dir=dirname($arrUrl['path']));
            if($dir=="/"){
                $dir="";
            }
        }
        if(is_array($href)&&count($href)>0){
            $href=array_unique($href);
            foreach($href as $key=>$val){
                $val=strtolower($val);
                if(preg_match('/^#*$/isU',$val)){
                    unset($href[$key]);
                }elseif(preg_match('/^\//isU',$val)){
                    $href[$key]='http://'.$arrUrl['host'].$val;
                }elseif(preg_match('/^javascript/isU',$val)){
                    unset($href[$key]);
                }elseif(preg_match('/^mailto:/isU',$val)){
                    unset($href[$key]);
                }elseif(!preg_match('/^\//isU',$val)&&strpos($val,'http://')===FALSE){
                    $href[$key]='http://'.$arrUrl['host'].$dir.'/'.$val;
                }
            }
        }

        return $href;
    }

    //Provides an Array of Image Src
    function getImgLinks($url){
        set_time_limit(0);
        $html=file_get_contents($url);
        preg_match_all("/<img(s*[^>]+s*)src=([\"|']?)([^\"'>\s]+)([\"|']?)/ies",$html,$out);
        $arrLink=$out[3];
        $arrUrl=parse_url($url);
        $dir='';
        if(isset($arrUrl['path'])&&!empty($arrUrl['path'])){
            $dir=str_replace("\\","/",$dir=dirname($arrUrl['path']));
            if($dir=="/"){
                $dir="";
            }
        }
        if(is_array($arrLink)&&count($arrLink)>0){
            $arrLink=array_unique($arrLink);
            foreach($arrLink as $key=>$val){
                $val=strtolower($val);
                if(preg_match('/^#*$/isU',$val)){
                    unset($arrLink[$key]);
                }elseif(preg_match('/^\//isU',$val)){
                    $arrLink[$key]='http://'.$arrUrl['host'].$val;
                }elseif(preg_match('/^javascript/isU',$val)){
                    unset($arrLink[$key]);
                }elseif(preg_match('/^mailto:/isU',$val)){
                    unset($arrLink[$key]);
                }elseif(!preg_match('/^\//isU',$val)&&strpos($val,'http://')===FALSE){
                    $arrLink[$key]='http://'.$arrUrl['host'].$dir.'/'.$val;
                }
            }
        }

        return $arrLink;
    }

    $app->get('/test', function() use ($app){
        $propertyInfo = array();


        $url = "http://www.realestate.com.au/property-apartment-vic-elwood-121533362";


        /*
         * the only thing that hardcoded is the url
         * everything else is reusable
         */

        writeJson ($url, $propertyInfo);
    //	writeJson ($url);

        $propertyInfo['day'] = "what is this";
        //print_r ($propertyInfo);

        $propertyDir = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/agentAssets/";
        //$propertyDir = "../assets/agentAssets/";

        $propertyDir .= $propertyInfo['agent_identifier'];
        $propertyDir .= '/';

        $templateDir = array (
            'banner' => $propertyDir . "banner.png",
            'bath' => $propertyDir . "bath.png",
            'bed' => $propertyDir . "bed.png",
            'bottom' => $propertyDir . "bottom.png",
            'car' => $propertyDir . "car.png",
            'font' => $propertyDir . "font.ttf",
            'logo' => $propertyDir . "logo.png"
        );

        echo json_encode($templateDir);

    });

?>
