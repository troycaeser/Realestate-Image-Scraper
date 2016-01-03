<?php
	include("{$_SERVER['DOCUMENT_ROOT']}/myApp/api/vendor/dom_parser.php");
//	include("../vendor/dom_parser.php");

	function writeJson ($url, &$arr) {

		$reqURL_local = $url;
		//Create a folder for the request property
		/*if(isset($reqURL_local)){
			$folder_name = substr(strstr($reqURL_local,'au/'),3);
			if(file_exists ($folder_name)):
				else:
				mkdir ("{$_SERVER['DOCUMENT_ROOT']}/myApp/assets/d_images/".$folder_name, 0777);
			endif;
		}
		echo '---1.1 Create property folder complete'.'</br>';*/

		//****************************************************************************
		//Get related data into an array and prepare them into Json

		$bed_no = $bath_no 
				= $car_no 
				= $street
				= $suburb
				= $agency
				= $agent_name
				= $auction_string
				= $price
				= $auction_time
				= $day_long
				= $day_short
				= "";

		$html = file_get_html($reqURL_local);
		$bed_no = $html->find('.rui-icon-bed', 0);
			if (strlen($bed_no) != 0)
			{
				$bed_no = $bed_no->next_sibling()->plaintext;
			}
		$bath_no = $html->find('.rui-icon-bath', 0);
			if (strlen($bath_no) != 0)
			{
				$bath_no = $bath_no->next_sibling()->plaintext;
			}
		$car_no = $html->find('.rui-icon-car', 0);
			if (strlen($car_no) != 0)
			{
				$car_no = $car_no->next_sibling()->plaintext;
			}
		$street = $html->find('span[itemprop="streetAddress"]', 0)->plaintext;
		$suburb = $html->find('span[itemprop="addressLocality"]', 0)->plaintext;
		$agency = $html->find('.agencyName', 0)->plaintext;

		//shorten agency
		$agency_identifier = sanitiseAgent($agency);

		$agent_name = $html->find('#agentContactInfo', 0)->first_child()->plaintext;
		$price = $html->find('.price', 0)->first_child();
			if (strlen($price) != 0)				//Check if the price is shown
			{
				$price = trim($price->plaintext);
			}		

		$auction_string = $html->find('div p span (text)',0);
		if (strlen($auction_string) != 0)		//Check if the auction date is avaibale
		{
			$auction_string = substr($auction_string,stripos($auction_string, ':') + 2);
			$day_short = strtolower(substr($auction_string, 0,3));
			$auction_string = substr($auction_string, 3);
			$auction_day = trim(substr($auction_string,0,stripos($auction_string, '-')));
			$auction_month = trim(substr($auction_string,stripos($auction_string, '-')+1,3));
			$auction_year = trim(substr($auction_string,strripos($auction_string, '-')+1,2));		
			
			$auction_full = strtolower(substr($auction_string, strpos($auction_string, '-') + 7));

			$auction_time_minutes = substr($auction_full, stripos($auction_full, ':') + 1, 2);

			if(intval($auction_time_minutes) > 0){
				$auction_time = strip_tags(strtolower(substr($auction_string, strpos($auction_string, '-') + 7)));
			}
			else{
				$auction_time = strip_tags(str_replace(trim(':'.$auction_time_minutes), "", $auction_full));
			}

			$day_long = dayFormat($day_short);

			// echo "word: ".$auction_time;
		}

		//*****************************************************************************
		//Get the image links
		/*$photoGlink = getPageLink($reqURL_local);
		$img_links = getImgLinks($photoGlink);

		//Generate 800*600 images
		$i = 0;
		foreach ($img_links as $cacheLink){
			$i++;
			$front = substr($cacheLink,0,26);
			$end = substr($cacheLink,33);
			$final = $front."/800x600/".$end;
			$modified_links[$i] = $final;
		}
		echo '---1.2 Get all required image links complete'.'</br>';*/

		$arr = array(
			'url'				=> $reqURL_local,
			'bed_no'			=> $bed_no,
			'bath_no'			=> $bath_no,
			'car_no'			=> $car_no,
			'price'				=> $price,
			'street'			=> $street,
			'suburb'			=> $suburb,
			'agency'			=> $agency,
			'agent_identifier'	=> $agency_identifier,
			'agent_name'		=> $agent_name,
			'auction_day'		=> $auction_day,
			'auction_month'		=> $auction_month,
			'auction_year'		=> $auction_year,
			'auction_time'		=> $auction_time,
			'day'				=> $day_long/*,
			'imageLinks'		=> $modified_links*/
		);
	//	$file = 'cache.json';
	//	file_put_contents($file, json_encode($arr));
	//	echo '---1.3 Save to local Json file complete'.'</br>';
	//	print_r ($arr);
	}


	//******************************************************************************
	function sanitiseAgent($agent){
		return substr($agent, 0, stripos($agent, ' '));
	}
/*
	//Filter Links!
	//1.1 Provides a Link with photogal
	function getPageLink($url){
		set_time_limit(0);
		$html=file_get_contents($url);
		preg_match_all("/<a(s*[^>]+s*)href=([\"|']?)([^\"'>\s]+)([\"|']?)/ies",$html,$out);
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
		$matched = preg_grep('~(photogal)~i', $arrLink);
		$matched_key = key($matched);
		$photogal_link = $matched[$matched_key];
		return $photogal_link;
	}
	//1.2 Provides an Array of Image Src
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
		$matched[] = preg_grep('~(65x48)~i', $arrLink);
		$matched_key = key($matched);
		$photogal_link = $matched[$matched_key];
		return $photogal_link;
	}*/
	//Get full name of the day
	function dayFormat($day){
		$day_full = "";
		switch($day){
			case "mon":
				$day_full = "Monday";
				break;
			case "tue":
				$day_full = "Tuesday";
				break;
			case "wed":
				$day_full = "Wednesday";
				break;
			case "thu":
				$day_full = "Thursday";
				break;
			case "fri":
				$day_full = "Friday";
				break;
			case "sat":
				$day_full = "Saturday";
				break;
			case "sun":
				$day_full = "Sunday";
				break;
		}
		return $day_full;
	}
?>
