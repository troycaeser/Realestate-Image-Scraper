<?php
	include 'resize-class.php';
	function resolveImgUrls ($fileDir) {

	}

	function resizeAll ($imgUrls, $agency_localDir, &$resizedUrls) {
		/*
		 * function takes an array of img urls, resize, save in the same dir and
		 * load the resized urls into the second parameter
		 * ----------
		 * 
		 * hardcode directories of json files
		 * 
		 * get json data from m.json
		 * load the data into a new object
		 * 
		 * foreach image in imgUrls
		 * - create a resizeObject
		 * - get width/ height from json object (retrieved earlier)
		 * - call resizeObject->resizeImage (args);
		 * - notice difference between main and other in m.json
		 */

		// $jsonDir = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/agentJson/";
		$jsonDir = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/agentJson/";
		
		$jsonDir .= $agency_localDir;
		$jsonDir .= "/m.json";

		$jsonString = file_get_contents ($jsonDir);
		$jsonObject = json_decode ($jsonString, true);

		// $resizedDir = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/testResize/";
		$resizedDir = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/testResize/";

		// resize main
		$width = $jsonObject['main']['size']['width'];
		$height = $jsonObject['main']['size']['height'];
		
		$resizeObject = new resize ($imgUrls[0]);
		$resizeObject->resizeImage ($width, $height, 'exact', "main-resized");
		$resizeObject->saveImage ($resizedDir."main-resized.jpg", 100);
		
		$resizedUrls[0] = $resizedDir."main-resized.jpg";

		// resize others
		$width = $jsonObject['other']['size']['width'];
		$height = $jsonObject['other']['size']['height'];

		$no_imgs = count ($imgUrls);
		for ($i=1; $i<$no_imgs; $i++) {
			$resizeObject = new resize ($imgUrls[$i]);
			$resizeObject->resizeImage ($width, $height, 'exact', $i."-resized");
			$resizeObject->saveImage ($resizedDir.$i."-resized.jpg", 100);
			
			$resizedUrls[$i] = $resizedDir.$i."-resized.jpg";
		}

		// print_arr ($imgUrls);
		// print_arr ($resizedUrls);
	}

	function print_arr ($arr) {
		echo "<pre>";
		print_r ($arr);
		echo "</pre>";
	}
?>
