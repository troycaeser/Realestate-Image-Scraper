
<?php
	function auction($jsonFile, $photo_dir, $cacheJ){
		$im = imagecreatefromjpeg($photo_dir);

		imagejpeg($im, $photo_dir, 100);
		imagedestroy($im);
	}

	function justListed($jsonFile, $photo_dir, $cacheJ){
		$im = imagecreatefromjpeg($photo_dir);

		imagejpeg($im, substr($photo_dir,0,(strlen($photo_dir)-5)).'jl.jpg', 100);
		imagedestroy($im);
	}

	function wm($watermark, $jsonFile, $im, $string){
		$stamp = imagecreatefrompng($watermark);
		$stamp_w = imagesx($stamp);
		$stamp_h = imagesy($stamp);

		if($string != "Banner"){
			$pos_x = $jsonFile['main'][$string]['pos_x'];
			$pos_y = $jsonFile['main'][$string]['pos_y'];
		}else{
			$pos_x = $jsonFile['main'][$string]['A']['banner']['pos_x'];
			$pos_y = $jsonFile['main'][$string]['A']['banner']['pos_y'];
		}

		imagecopy(
			$im,
			$stamp,
			$pos_x,
			$pos_y,
			0, 0,
			$stamp_w,
			$stamp_h);
		//echo "--".$string." added<br />";
	}

	function txt($im, $font, $mJson, $string, $text, $day, $t_len){

		$font_color_r = $mJson['main']['Text']['color_r'];
		$font_color_g = $mJson['main']['Text']['color_g'];
		$font_color_b = $mJson['main']['Text']['color_b'];
		$angle = $mJson['main']['Text']['angle'];
		$color = imagecolorallocate($im, $font_color_r, $font_color_g, $font_color_b);

		// $color = imagecolorallocate($im,255,255,255);

		if($string == "Banner"){
			$font_size = $mJson['main'][$string]['A']['text']['font_size'];
			$font_pos_x = $mJson['main'][$string]['A']['text']['t_pos_x'];
			$font_pos_y = $mJson['main'][$string]['A']['text']['t_pos_y'];
			$angle = $mJson['main'][$string]['A']['text']['angle'];
			if($day){
				$font_size = $mJson['main'][$string]['A']['text']['Day'][$day][$t_len]['font_size'];
				$font_pos_x = $mJson['main'][$string]['A']['text']['Day'][$day][$t_len]['t_pos_x'];
				$font_pos_y = $mJson['main'][$string]['A']['text']['Day'][$day][$t_len]['t_pos_y'];
				$angle = $mJson['main'][$string]['A']['text']['angle'];

				echo $font_size;
			}
		}
		else{
			$font_size = $mJson['main']['Text']['font_size'];
			$font_pos_x = $mJson['main'][$string]['t_pos_x'];
			$font_pos_y = $mJson['main'][$string]['t_pos_y'];
		}

		//add bed_no
		imagettftext(
			$im,
			$font_size,
			$angle,
			$font_pos_x,
			$font_pos_y,
			$color,
			$font,
			$text);
	}
?>