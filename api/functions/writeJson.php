<?php
//	include("{$_SERVER['DOCUMENT_ROOT']}/myApp/api/vendor/dom_parser.php");
//	include("../vendor/dom_parser.php");

	function writeJson ($url, &$arr) {
		$reqURL_local = $url;

		$bed_no =
		$bath_no =
		$car_no =
		$street =
		$suburb =
		$agency =
		$agent_name =
		$agent_no =
		$auction_string =
		$price =
		$auction_time =
		$day_long =
		$day_short =
		"";

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
		$agent_no = $html->find('#agentContactInfo', 0)->first_child()->next_sibling()->first_child()->plaintext;

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
			'agent_no'			=> $agent_no,
			'auction_day'		=> $auction_day,
			'auction_month'		=> $auction_month,
			'auction_year'		=> $auction_year,
			'auction_time'		=> $auction_time,
			'day'				=> $day_long/*,
			'imageLinks'		=> $modified_links*/
		);
	}


	//******************************************************************************
	function sanitiseAgent($agent){
		return substr($agent, 0, stripos($agent, ' '));
	}

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
