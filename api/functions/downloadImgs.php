<?php
	function downloadAll ($imgs, $dir, &$imgUrls) {
		$id = 0;
		foreach ($imgs as $img) {
			downloadSingle ($img, $id, $dir);

			$imgUrls[$id] = $dir.$id.".jpg";
			$id ++;
		}
	}

	function downloadSingle ($img, $id, $dir) {
		$theImage = file_get_contents ($img);
	//	echo $id;

		$imgFile = fopen ($dir.$id.".jpg", 'wb');
		fwrite ($imgFile, $theImage);
		fclose ($imgFile);
	}
?>