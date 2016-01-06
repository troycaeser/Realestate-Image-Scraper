<?php
	include_once 'resize-class.php';
	include_once 'loadJsonObject.php';
	function resolveImgUrls ($fileDir) {

	}

	function resizeSingleMain ($imgUrl, $jsonObject, $resizedDir, &$resizedUrl) {
		/*
		 * function takes url of 1 single image, resize, save and
		 * load the resized url into the second parameter
		 */


		$width = $jsonObject['main']['size']['width'];
		$height = $jsonObject['main']['size']['height'];
		
		$resizeObject = new resize ($imgUrl);
		$resizeObject->resizeImage ($width, $height, 'exact', "main-resized");
		$resizeObject->saveImage ($resizedDir."main-resized.jpg", 100);
		
		$resizedUrl = $resizedDir."main-resized.jpg";
	}

	function resizeSingleOther ($imgUrl, $jsonObject, $resizedDir, $id, &$resizedUrl) {
		/*
		 * similar to resizeSingleMain()
		 */

		$width = $jsonObject['other']['size']['width'];
		$height = $jsonObject['other']['size']['height'];

		$resizeObject = new resize ($imgUrl);
		$resizeObject->resizeImage ($width, $height, 'exact', $id."-resized");
		$resizeObject->saveImage ($resizedDir.$id."-resized.jpg", 100);
		
		$resizedUrl = $resizedDir.$id."-resized.jpg";
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

		$jsonObject = get_json_object ($agency_localDir);

		// $resizedDir = "{$_SERVER['DOCUMENT_ROOT']}/myApp/api/assets/testResize/";
		$resizedDir = "{$_SERVER['DOCUMENT_ROOT']}/api/assets/testResize/";

		// resize main
		resizeSingleMain ($imgUrls[0], $jsonObject, $resizedDir, $resizedUrls[0]);

		// resize others

		$no_imgs = count ($imgUrls);
		for ($i=1; $i<$no_imgs; $i++) {
			resizeSingleOther ($imgUrls[$i], $jsonObject, $resizedDir, $i, $resizedUrls[$i]);
		}

		print_arr ($imgUrls);
		print_arr ($resizedUrls);
	}

	function print_arr ($arr) {
		echo "<pre>";
		print_r ($arr);
		echo "</pre>";
	}
?>
