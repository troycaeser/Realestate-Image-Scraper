<?php
		Class resize
		{
			// *** Class variables
			private $image;
		    private $width;
		    private $height;
			private $imageResized;

			function __construct($fileName)
			{
				// *** Open up the file
				$this->image = $this->openImage($fileName);

			    // *** Get width and height
			    $this->width  = imagesx($this->image);
			    $this->height = imagesy($this->image);
			}

			## --------------------------------------------------------

			private function openImage($file)
			{
				// *** Get extension
				$extension = strtolower(strrchr($file, '.'));

				switch($extension)
				{
					case '.jpg':
					case '.jpeg':
						$img = @imagecreatefromjpeg($file);
						break;
					case '.gif':
						$img = @imagecreatefromgif($file);
						break;
					case '.png':
						$img = @imagecreatefrompng($file);
						break;
					default:
						$img = false;
						break;
				}
				return $img;
			}

			## --------------------------------------------------------

			public function resizeImage($newWidth, $newHeight, $option="auto", $name)
			{
				// *** Get optimal width and height - based on $option
				$optionArray = $this->getDimensions($newWidth, $newHeight, $option);

				$optimalWidth  = $optionArray['optimalWidth'];
				$optimalHeight = $optionArray['optimalHeight'];


				// *** Resample - create image canvas of x, y size
				$this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);

				//the 32 at the end means the "bottom" size of the image. Its just blank space.
				if($name == '1'){
					imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height + 70);
				}else{
					imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);
				}


				// *** if option is 'crop', then crop too
				if ($option == 'crop') {
					$this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
				}
			}

			## --------------------------------------------------------
			
			private function getDimensions($newWidth, $newHeight, $option)
			{

			   switch ($option)
				{
					case 'exact':
						$optimalWidth = $newWidth;
						$optimalHeight= $newHeight;
						break;
					case 'portrait':
						$optimalWidth = $this->getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
						break;
					case 'landscape':
						$optimalWidth = $newWidth;
						$optimalHeight= $this->getSizeByFixedWidth($newWidth);
						break;
					case 'auto':
						$optionArray = $this->getSizeByAuto($newWidth, $newHeight);
						$optimalWidth = $optionArray['optimalWidth'];
						$optimalHeight = $optionArray['optimalHeight'];
						break;
					case 'crop':
						$optionArray = $this->getOptimalCrop($newWidth, $newHeight);
						$optimalWidth = $optionArray['optimalWidth'];
						$optimalHeight = $optionArray['optimalHeight'];
						break;
				}
				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			private function getSizeByFixedHeight($newHeight)
			{
				$ratio = $this->width / $this->height;
				$newWidth = $newHeight * $ratio;
				return $newWidth;
			}

			private function getSizeByFixedWidth($newWidth)
			{
				$ratio = $this->height / $this->width;
				$newHeight = $newWidth * $ratio;
				return $newHeight;
			}

			private function getSizeByAuto($newWidth, $newHeight)
			{
				if ($this->height < $this->width)
				// *** Image to be resized is wider (landscape)
				{
					$optimalWidth = $newWidth;
					$optimalHeight= $this->getSizeByFixedWidth($newWidth);
				}
				elseif ($this->height > $this->width)
				// *** Image to be resized is taller (portrait)
				{
					$optimalWidth = $this->getSizeByFixedHeight($newHeight);
					$optimalHeight= $newHeight;
				}
				else
				// *** Image to be resizerd is a square
				{
					if ($newHeight < $newWidth) {
						$optimalWidth = $newWidth;
						$optimalHeight= $this->getSizeByFixedWidth($newWidth);
					} else if ($newHeight > $newWidth) {
						$optimalWidth = $this->getSizeByFixedHeight($newHeight);
						$optimalHeight= $newHeight;
					} else {
						// *** Sqaure being resized to a square
						$optimalWidth = $newWidth;
						$optimalHeight= $newHeight;
					}
				}

				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			private function getOptimalCrop($newWidth, $newHeight)
			{

				$heightRatio = $this->height / $newHeight;
				$widthRatio  = $this->width /  $newWidth;

				if ($heightRatio < $widthRatio) {
					$optimalRatio = $heightRatio;
				} else {
					$optimalRatio = $widthRatio;
				}

				$optimalHeight = $this->height / $optimalRatio;
				$optimalWidth  = $this->width  / $optimalRatio;

				return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
			}

			## --------------------------------------------------------

			private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight)
			{
				// *** Find center - this will be used for the crop
				$cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
				$cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

				$crop = $this->imageResized;
				//imagedestroy($this->imageResized);

				// *** Now crop from center to exact requested size
				$this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
				imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
			}

			## --------------------------------------------------------
			
			public function mainImageManipulate(
									$logo,
									$bottom,
									$bed,
									$bed_num,
									$bath,
									$bath_num,
									$car,
									$car_num,
									$banner,
									$auction_time,
									$auction_date,
									$photo){

				//LOGO
				// Load the stamp and the photo to apply the watermark to
				$stamp_logo = imagecreatefrompng($logo);
				$stamp_bottom = imagecreatefromjpeg($bottom);
				$stamp_bed = imagecreatefrompng($bed);
				$stamp_bed_no = $bed_num;
				$stamp_bath = imagecreatefrompng($bath);
				$stamp_bath_no = $bath_num;
				$stamp_car = imagecreatefrompng($car);
				$stamp_car_no = $car_num;
				$stamp_banner = imagecreatefrompng($banner);
				$stamp_auction = 'Auction this';
				$stamp_auction_time = $auction_date." ".$auction_time;

				$font = '../bin/chisholm_gamon/museo500.ttf';

				$im = imagecreatefromjpeg($photo);
				$color = imagecolorallocate($im, 255, 255, 255);

				// Set the margins for the stamp
				$marge_right = 5;
				$marge_bottom = 5;

				//logo_height/width
				$logo_x = imagesx($stamp_logo);
				$logo_y = imagesy($stamp_logo);

				//bottom_height/width
				// $bottom_x = imagesx($stamp_bottom);
				$bottom_y = imagesy($stamp_bottom);

				// Copy the stamp image onto our photo using the margin offsets and the photo 
				// width to calculate positioning of the stamp. 
				//add logo
				imagecopy(
					$im,
					$stamp_logo,
					imagesx($im) - $logo_x - $marge_right,
					$marge_bottom,
					0, 0,
					imagesx($stamp_logo),
					imagesy($stamp_logo));

				//add bottom
				imagecopy(
					$im,
					$stamp_bottom,
					0,
					imagesy($im) - $bottom_y,
					0, 0,
					imagesx($stamp_bottom),
					imagesy($stamp_bottom));

				//add bed
				imagecopy(
					$im,
					$stamp_bed,
					25,
					imagesy($im) - $bottom_y,
					0, 0,
					imagesx($stamp_bed),
					imagesy($stamp_bed));

				//add bed_no
				imagettftext(
					$im,
					20,
					0,
					25 + imagesx($stamp_bed) + 25,
					imagesy($im) - 6,
					$color,
					$font,
					$stamp_bed_no);

				//add bath
				imagecopy(
					$im,
					$stamp_bath,
					25 + imagesx($stamp_bed) + 60,
					imagesy($im) - $bottom_y,
					0, 0,
					imagesx($stamp_bath),
					imagesy($stamp_bath));

				//add bath_no
				imagettftext(
					$im,
					20,
					0,
					25 + imagesx($stamp_bed) + 60 + imagesx($stamp_bath) + 25,
					imagesy($im) - 6,
					$color,
					$font,
					$stamp_bath_no);

				//add car
				imagecopy(
					$im,
					$stamp_car,
					25 + imagesx($stamp_bed) + 60 + imagesx($stamp_bath) + 60,
					imagesy($im) - $bottom_y,
					0, 0,
					imagesx($stamp_car),
					imagesy($stamp_car));

				//add car_no
				imagettftext(
					$im,
					20,
					0,
					25 + imagesx($stamp_bed) + 60 + imagesx($stamp_bath) + 60 + imagesx($stamp_car) + 25,
					imagesy($im) - 6,
					$color,
					$font,
					$stamp_car_no);

				//add Banner
				imagecopy(
					$im,
					$stamp_banner,
					0,
					0,
					0, 0,
					imagesx($stamp_banner),
					imagesy($stamp_banner));

				if(strlen($auction_time) == 4 || strlen($auction_time) == 3){
					//add the first line in the banner
					imagettftext($im, 20, 43.5, 13, 115, $color, $font, $stamp_auction);

					//add second line in the banner
					imagettftext($im, 20, 43.5, 15, 148, $color, $font, $stamp_auction_time);

				}else if(strlen($auction_time) == 6){
					//add the first line in the banner
					imagettftext($im, 19, 43.5, 13, 115, $color, $font, $stamp_auction);

					//add the second line in the banner
					imagettftext($im, 19, 43.5, 12, 150, $color, $font, $stamp_auction_time);

				}else if(strlen($auction_time) == 7){
					//add the first line in the banner
					imagettftext($im, 20, 43.5, 13, 115, $color, $font, $stamp_auction);

					//add the second line in the banner
					imagettftext($im, 19, 43.5, 10, 155, $color, $font, $stamp_auction_time);
				}

				// Output and free memory
				imagejpeg($im, $photo, 100);

				imagedestroy($im);
			}

			public function secondaryImageManipulate($logo, $photo){
				$stamp_logo = imagecreatefrompng($logo);
				$im = imagecreatefromjpeg($photo);

				//logo_height/width
				$logo_x = imagesx($stamp_logo);
				$logo_y = imagesy($stamp_logo);

				// Set the margins for the stamp
				$marge_right = 5;
				$marge_bottom = 5;

				//add logo
				imagecopy(
					$im,
					$stamp_logo,
					imagesx($im) - $logo_x,
					imagesy($im) - $logo_y,
					0, 0,
					imagesx($stamp_logo),
					imagesy($stamp_logo));

				// Output and free memory
				imagejpeg($im, $photo, 100);

				imagedestroy($im);
			}

			## --------------------------------------------------------

			public function saveImage($savePath, $imageQuality="100")
			{
				// *** Get extension
        		$extension = strrchr($savePath, '.');
       			$extension = strtolower($extension);

				switch($extension)
				{
					case '.jpg':
					case '.jpeg':
						if (imagetypes() & IMG_JPG) {
							imagejpeg($this->imageResized, $savePath, $imageQuality);
						}
						break;

					case '.gif':
						if (imagetypes() & IMG_GIF) {
							imagegif($this->imageResized, $savePath);
						}
						break;

					case '.png':
						// *** Scale quality from 0-100 to 0-9
						$scaleQuality = round(($imageQuality/100) * 9);

						// *** Invert quality setting as 0 is best, not 9
						$invertScaleQuality = 9 - $scaleQuality;

						if (imagetypes() & IMG_PNG) {
							 imagepng($this->imageResized, $savePath, $invertScaleQuality);
						}
						break;

					// ... etc

					default:
						// *** No extension - No save.
						break;
				}

				imagedestroy($this->imageResized);
				//echo $savePath;
			}


			## --------------------------------------------------------

		}
?>
