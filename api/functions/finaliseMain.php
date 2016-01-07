<?php
	include_once ("getHTMLContents.php");
	include_once ("makeTemplateDir.php");
	include_once ("loadJsonObject.php");

	function finaliseMainAdItem ($propertyInfo, $jsonObject, $dest, $imgUrl) {
		$templateDir = array();
		$templateDirWeb = array();
		makeTemplateDir ($propertyInfo, $templateDir, $templateDirWeb);

		$mainImg = imagecreatefromjpeg ($imgUrl);
		$mainImg2 = imagecreatefromjpeg ($imgUrl);
		$no_features = 3;
		if ($propertyInfo['no_car'] == "N/A")
			$no_features = 2;

		// $no_features = 2;
		allocateTemplates ($mainImg, $jsonObject, $templateDir, $no_features);
		allocateTemplates ($mainImg2, $jsonObject, $templateDir, $no_features);
		fillText ($mainImg, $jsonObject, $propertyInfo, $templateDir, "auction", $no_features);
		fillText ($mainImg2, $jsonObject, $propertyInfo, $templateDir, "justlisted", $no_features);

		// $dest = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/testDraw/";
		
		imagejpeg ($mainImg, $dest."0.jpg", 100);
		imagejpeg ($mainImg2, $dest."00.jpg", 100);

		imagedestroy ($mainImg);
		imagedestroy ($mainImg2);

		// allocateLogo (imgUrls, $jsonObject, $templateDir);
	}

	function allocateTemplates (&$mainImg, $jsonObject, $templateDir, $no_features) {
		$templateItems = array (
			 "Bottom", "Bed", "Bath", "Car", "Banner", "Logo"
		);
		if ($no_features == 2) {
			$templateItems = array (
				 "Bottom", "Bed", "Bath", "Banner", "Logo"
			);
		}

		foreach ($templateItems as $itemName) {
			$item_i = imagecreatefrompng ($templateDir[$itemName]);

			$i_src_x = 0;
			$i_src_y = 0;

			$i_dst_x = $jsonObject['main'][$itemName]['pos_x'];
			$i_dst_y = $jsonObject['main'][$itemName]['pos_y'];

			if ($no_features == 2) {
				if ($itemName == "Bed" || $itemName == "Bath") {
					$i_dst_x = $jsonObject['main'][$itemName]['pos_x_2'];
					$i_dst_y = $jsonObject['main'][$itemName]['pos_y_2'];
				}
			}

			$i_w = imagesx ($item_i);
			$i_h = imagesy ($item_i);

			imagecopy (
				$mainImg, $item_i, $i_dst_x, $i_dst_y, $i_src_x, $i_src_y, $i_w, $i_h
			);

			imagedestroy ($item_i);
		}
	}

	function fillText (&$mainImg, $jsonObject, $propertyInfo, $templateDir, $listingType, $no_features) {
		// Auction this
		// Saturday 2pm
		// 3 1 2 or 3 1

		// general style
		$banner_colour = imagecolorallocate ($mainImg, 255, 255, 255);
		$font = $templateDir['Font'];

		// banner text
		$banner_auction_top = "Auction this";
		$banner_auction_bot = $propertyInfo['auction_day']." ".$propertyInfo['auction_hour'];

		$banner_jl_top = "JUST";
		$banner_jl_bot = "LISTED";

		// add banner text
		$bannerJson = $jsonObject['main']['Banner'];
		$banner_angle = $bannerJson['angle'];
		if ($listingType == "auction") {
			// banner text style
			// top
			$tmp = $bannerJson['A']['top'];
			$top_size = $tmp['font_size'];
			$top_x = $tmp['t_pos_x'];
			$top_y = $tmp['t_pos_y'];

			imagettftext ($mainImg, $top_size, $banner_angle, $top_x, $top_y, $banner_colour, $font, $banner_auction_top);

			// bottom
			$hourType = strlen ($propertyInfo['auction_hour']);
			// print_r ($propertyInfo);
			$tmp = $bannerJson['A']['bottom'][$propertyInfo['auction_day']][$hourType];
			$bottom_size = $tmp['font_size'];
			$bottom_x = $tmp['t_pos_x'];
			$bottom_y = $tmp['t_pos_y'];

			imagettftext ($mainImg, $bottom_size, $banner_angle, $bottom_x, $bottom_y, $banner_colour, $font, $banner_auction_bot);
		}
		else if ($listingType == "justlisted") {
			$size = $bannerJson['J']['font_size'];
			// top
			$tmp = $bannerJson['J']['top'];
			$top_x = $tmp['t_pos_x'];
			$top_y = $tmp['t_pos_y'];

			imagettftext ($mainImg, $size, $banner_angle, $top_x, $top_y, $banner_colour, $font, $banner_jl_top);

			// bottom
			$tmp = $bannerJson['J']['bottom'];
			$bottom_x = $tmp['t_pos_x'];
			$bottom_y = $tmp['t_pos_y'];

			imagettftext ($mainImg, $size, $banner_angle, $bottom_x, $bottom_y, $banner_colour, $font, $banner_jl_bot);
		}

		// add bed, bath, car text

		$tmp = $jsonObject['main']['Text'];
		$size = $tmp['font_size'];
		$angle = 0;
		$r = $tmp['colour_r'];
		$g = $tmp['colour_g'];
		$b = $tmp['colour_b'];
		$colour = imagecolorallocate ($mainImg, $r, $g, $b);

		$features = array (
			"Bed", "Bath", "Car"
		);
		if ($no_features == 2) {
			$features = array (
				"Bed", "Bath"
			);
		}
		
		foreach ($features as $f) {
			$property_key = "no_".strtolower ($f);
			$tmp = $jsonObject['main'][$f];

			$text = $propertyInfo[$property_key];
			$x = $tmp['t_pos_x'];
			$y = $tmp['t_pos_y'];

			if ($no_features == 2) {
				$x = $tmp['t_pos_x_2'];
				$y = $tmp['t_pos_y_2'];
			}

			imagettftext ($mainImg, $size, $angle, $x, $y, $colour, $font, $text);
		}
		// for loop
		// $no_bed = $propertyInfo['no_bed'];
		// $no_car = $propertyInfo['no_car'];
		// $no_bath = $propertyInfo['no_bath'];
	}

	function allocateLogo ($imgUrls, $jsonObject, $dest, $templateDir) {
		// imagecopy (dst_im, src_im, dst_x, dst_y, src_x, src_y, src_w, src_h)
		// src = templateDir[logo]
		// loop
		// dst = imgUrls[i]
		// dst_xy = jsonObject[logo]
		// src_xy = 0
		// src_wh = imagesxy (src)

		$logo_path = $templateDir['Logo'];
		$srcImg = imagecreatefrompng ($logo_path);
		$src_x = 0;
		$src_y = 0;
		$src_w = imagesx ($srcImg);
		$src_h = imagesy ($srcImg);
		$dst_x = $jsonObject['main']['Logo']['pos_x'];
		$dst_y = $jsonObject['main']['Logo']['pos_y'];

		$no_imgs = count ($imgUrls);
		// $dest = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/testResize/";
		
		for ($i=1; $i<$no_imgs; $i++) {
			$img_path = $imgUrls[$i];
			$dstImg = imagecreatefromjpeg ($img_path);
			imagecopy ($dstImg, $srcImg, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);
			imagejpeg ($dstImg, $dest.$i.".jpg", 100);
		}

		imagedestroy ($srcImg);
	}
?>