<?php
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
				$carouselLink = resolvePageLinks($url);
				$imgLinks = getImgLinks($url);
				$matched[] = preg_grep('~(65x48)~i', $imgLinks);
				$matched_key = key($matched);
				$finalLinks = $matched[$matched_key];
				break;
			case "milesre.com.au":
				$imgLinks = getImgLinks($url);
				$matched[] = preg_grep('~(width=61)~i', $imgLinks);
				$matched_key = key($matched);
				$finalLinks = $matched[$matched_key];
				break;
			case "portplus.com":
				$imgLinks = getImgLinks($url);
				$matched[] = preg_grep('~(width=61)~i', $imgLinks);
				$matched_key = key($matched);
				$finalLinks = $matched[$matched_key];
				break;
		}

		print_r($finalLinks);
	});

	$app->get('/crawl', function(){
		echo "get crawl works";
	});

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
?>