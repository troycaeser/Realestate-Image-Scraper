<?php
	include_once ("getHTMLContents.php");
	include_once ("makeTemplateDir.php");

	function finaliseMainAdItem ($url, $imgUrl) {
		$propertyInfo = array();
		getHTML ($url, $propertyInfo);

		$templateDir = array();
		makeTemplateDir ($url, $propertyInfo, $templateDir);

		// $jsonDir = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/agentJson/";
		$jsonDir = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/agentJson/";
		
		$jsonDir .= $propertyInfo['agency_localDir'];
		$jsonDir .= "/m.json";

		$jsonString = file_get_contents ($jsonDir);
		$jsonObject = json_decode ($jsonString, true);

		$mainImg = imagecreatefromjpeg ($imgUrl);
		allocateTemplates ($mainImg, $jsonObject, $templateDir);
		// fillText ($mainImg, $jsonObject, $propertyInfo);

		// $dest = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/testDraw/";
		$dest = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/testDraw/";
		
		imagejpeg ($mainImg, $dest."img0.jpg", 100);
	}

	function allocateTemplates (&$mainImg, $jsonObject, $templateDir) {
		$templateItems = array (
			 "Bottom", "Bed", "Bath", "Car", "Banner", "Logo"
		);

		foreach ($templateItems as $itemName) {
			$item_i = imagecreatefrompng ($templateDir[$itemName]);

			$i_src_x = 0;
			$i_src_y = 0;

			$i_dst_x = $jsonObject['main'][$itemName]['pos_x'];
			$i_dst_y = $jsonObject['main'][$itemName]['pos_y'];

			$i_w = imagesx ($item_i);
			$i_h = imagesy ($item_i);

			imagecopy (
				$mainImg, $item_i, $i_dst_x, $i_dst_y, $i_src_x, $i_src_y, $i_w, $i_h
			);
		}
	}

	function fillText (&$mainImg, $jsonObject, $propertyInfo) {
		// Auction this
		// Saturday 2pm
		// 3 1 2

		$banner_auction_top = "Auction this";
		$banner_auction_bot = $propertyInfo['auction_day']." ".$propertyInfo['auction_time'];

		$banner_justlisted = "Just Listed";

		// for loop
		// $no_bed = $propertyInfo['no_bed'];
		// $no_car = $propertyInfo['no_car'];
		// $no_bath = $propertyInfo['no_bath'];
	}
?>